<?php
use Symfony\Component\HttpFoundation\Response;

date_default_timezone_set('Asia/Tokyo');

$app->get('/exercise/part1',function() use($app) {
    $message_line = [];
    $year = date('Y');
    for($i = 0; $i <= 1000; $i++){
        $message_line[] = ['message' => 'Sunrise' . $year . '　チューニングバトル！誰が栄冠の1位になるのか？0.001秒を削る熱いバトル！！！誰が？誰が？誰が？誰が栄冠の1位に！！！！！！！！！！！'];
    }
    $body = $app['twig']->render('exercise_part1.twig',['message_line' => $message_line]);
    $response = new Response($body, 200);
    $response->setLastModified(new \DateTime($year.'-01-01 00:00:00'));
    return $response;
});

$app->get('/exercise/part2',function() use($app) {
    $sql = 'select name,count(distinct message) as messages, count(distinct follow) as follow, count(distinct follower) as follower from (select name,messages.id as message,follows.id as follow,follower.id as follower from users left join messages on users.id = messages.user_id left join follows as follows on users.id = follows.user_id left join follows as follower on users.id = follower.follow_user_id where users.id = ?)summary group by name';
    $id = mt_rand(1,100000);
    $con = $app['db'];
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $user = $result['name'];
    $messages = $result['messages'];
    $follow = $result['follow'];
    $follower = $result['follower'];

    $sql = 'select * from messages where id = ? order by created_at desc limit 10';
    $sth = $con->prepare($sql);
    $sth->execute(array($id));
    $message_line = $sth->fetchAll();
    return $app['twig']->render('exercise_part2.twig',['user' => $user,'messages' => $messages,'follow' => $follow,'follower' => $follower,'message_line' => $message_line]);
});

$app->post('/exercise/part3',function() use($app) {
    $con = $app['db'];
    $sql = 'insert into messages values(null,?,?,?,now(),now())';
    $sth = $con->prepare($sql);
    $id = mt_rand(1,1000007);
    $sth->execute(array($id,$_POST['title'],$_POST['message'].'by '.$id));
    return $app->redirect('/exercise/part1');
});

$app->get('/exercise/part4',function() use($app) {
    $con = $app['db'];
    $sql = 'select * from messages where title = ? order by created_at desc limit 10';
    $sth = $con->prepare($sql);
    $sth->execute(array('チューニングバトル'));
    $message_line = $sth->fetchAll();
    return $app['twig']->render('exercise_part2.twig',['message_line' => $message_line]);
});

$app->get('/exercise/part5',function() use($app) {
    return $app['twig']->render('exercise_part5.twig');
});
