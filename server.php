<?php
//Реализация многопоточного сервера на PHP

//Подключение к socket server
$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($server, '127.0.0.1', 8080);
socket_listen($server);

$pool = new Pool(10, Worker::class); //Указания кол-во пулов потока

//Реализация Класса Многопоточности
class Task extends Threaded
{
    protected $socket;

    public function __construct($socket)
    {
        $this->socket = $socket;
    }

    public function run()
    {
		//Запись в сокет
        if (!empty($this->socket)) {
            $response = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nContent-Length: 12\r\n\r\nHello world!";
            socket_write($this->socket, $response, strlen($response));
        }
    }
}

//Регистрация функции
register_shutdown_function(function () use ($server, $pool) {
    if (!empty($server)) {
        socket_close($server);
    }

    $pool->shutdown();
});

//Массив серверов
$servers = [$server];

while (true) {
    $read = $servers;
	
	//Принимает  массивы сокетов
    if (socket_select($read, $write, $except, 0) >= 0 && in_array($server, $read)) {
		//Отправить сокет в паток
        $task = new Task(socket_accept($server));
        $pool->submit($task);
    }
}
?>