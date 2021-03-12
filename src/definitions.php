<?php

namespace PHPMaker2021\simexamerica;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "escenario" => \DI\create(Escenario::class),
    "grupo" => \DI\create(Grupo::class),
    "participantes" => \DI\create(Participantes::class),
    "subgrupo" => \DI\create(Subgrupo::class),
    "tareas" => \DI\create(Tareas::class),
    "inicio" => \DI\create(Inicio::class),
    "paisgmt" => \DI\create(Paisgmt::class),
    "correo" => \DI\create(Correo::class),
    "email2" => \DI\create(Email2::class),
    "users" => \DI\create(Users::class),
    "mensagens" => \DI\create(Mensagens::class),
    "incidente" => \DI\create(Incidente::class),
    "tipo" => \DI\create(Tipo::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "audittrail" => \DI\create(Audittrail::class),
    "menucontenedor" => \DI\create(Menucontenedor::class),
    "mensajes" => \DI\create(Mensajes::class),
    "chat_ini" => \DI\create(ChatIni::class),
    "todos" => \DI\create(Todos::class),
    "view_from" => \DI\create(ViewFrom::class),
    "historico" => \DI\create(Historico::class),
    "actor_simulado" => \DI\create(ActorSimulado::class),
    "mensajes_usuarios" => \DI\create(MensajesUsuarios::class),
    "grupos" => \DI\create(Grupos::class),
    "onlyoffice" => \DI\create(Onlyoffice::class),
    "timeline" => \DI\create(Timeline::class),
    "archivos_doc" => \DI\create(ArchivosDoc::class),
    "permisos_doc" => \DI\create(PermisosDoc::class),

    // User table
    "usertable" => \DI\get("users"),
];
