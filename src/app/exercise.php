<?php
use Symfony\Component\HttpFoundation\Response;

date_default_timezone_set('Asia/Tokyo');

$app->get('/exercise/part1',function() use($app) {
    return $app['twig']->render('exercise_part1.twig');
});

$app->get('/exercise/part2',function() use($app) {
    $con = $app['db'];
    $sql = 'select name,follow,follower,messages,message,created_at from profile left join messages on profile.id = messages.id where profile.id = ?';
    $sth = $con->prepare($sql);
    $id = mt_rand(1,100000);
    $sth->execute(array($id));
    $result = $sth->fetch(PDO::FETCH_BOTH);
    $user = $result['name'];
    $messages = $result['messages'];
    $follow = $result['follow'];
    $follower = $result['follower'];
    $message_line = array(array('message' => $result['message'], 'created_at' => $result['created_at']));
    return $app['twig']->render('exercise_part2.twig',['user' => $user,'messages' => $messages,'follow' => $follow,'follower' => $follower,'message_line' => $message_line]);
});

$app->post('/exercise/part3',function() use($app) {
    $con = $app['db'];
    $now = new \DateTime('now');
    $now = $now->format('Y:m:d H:i:s');
    $sql = 'insert into messages values(null,?,?,?,?,?)';
    $sth = $con->prepare($sql);
    $id = mt_rand(1,1000007);
    $sth->execute(array($id,$_POST['title'],$_POST['message'].'by '.$id, $now, $now));

    if ($_POST['title'] == 'チューニングバトル') {
	$message = array('user_id' => $id, 'title' => $_POST['title'] , 'message' => $_POST['message'].'by '.$id, 'created_at' => $now, 'updated_at' => $now);
        $resent_messages = $app['memcached']->get('resent_messages');
	array_unshift($resent_messages, $message);
	array_pop($resent_messages);
	$app['memcached']->set('resent_messages', $resent_messages);

	$sql = 'update profile set messages = messages + 1 where id = ?';
	$sth = $con->prepare($sql);
	$sth->execute(array($id));

	$client = new GuzzleHttp\Client();
	$res = $client->request('REFRESH', 'http://localhost/');

    }
    return $app->redirect('/exercise/part1');
});

$app->get('/exercise/part4',function() use($app) {
    $resent_messages = $app['memcached']->get('resent_messages');
    return $app['twig']->render('exercise_part2.twig', ['message_line' => $resent_messages]);
});

$app->get('/exercise/part5',function() use($app) {
    return $app['twig']->render('exercise_part5.twig');
});
