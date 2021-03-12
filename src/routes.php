<?php

namespace PHPMaker2021\simexamerica;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // escenario
    $app->any('/EscenarioList[/{id_escenario}]', EscenarioController::class . ':list')->add(PermissionMiddleware::class)->setName('EscenarioList-escenario-list'); // list
    $app->any('/EscenarioAdd[/{id_escenario}]', EscenarioController::class . ':add')->add(PermissionMiddleware::class)->setName('EscenarioAdd-escenario-add'); // add
    $app->any('/EscenarioView[/{id_escenario}]', EscenarioController::class . ':view')->add(PermissionMiddleware::class)->setName('EscenarioView-escenario-view'); // view
    $app->any('/EscenarioEdit[/{id_escenario}]', EscenarioController::class . ':edit')->add(PermissionMiddleware::class)->setName('EscenarioEdit-escenario-edit'); // edit
    $app->any('/EscenarioDelete[/{id_escenario}]', EscenarioController::class . ':delete')->add(PermissionMiddleware::class)->setName('EscenarioDelete-escenario-delete'); // delete
    $app->group(
        '/escenario',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':list')->add(PermissionMiddleware::class)->setName('escenario/list-escenario-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':add')->add(PermissionMiddleware::class)->setName('escenario/add-escenario-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':view')->add(PermissionMiddleware::class)->setName('escenario/view-escenario-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':edit')->add(PermissionMiddleware::class)->setName('escenario/edit-escenario-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_escenario}]', EscenarioController::class . ':delete')->add(PermissionMiddleware::class)->setName('escenario/delete-escenario-delete-2'); // delete
        }
    );

    // grupo
    $app->any('/GrupoList[/{id_grupo}]', GrupoController::class . ':list')->add(PermissionMiddleware::class)->setName('GrupoList-grupo-list'); // list
    $app->any('/GrupoAdd[/{id_grupo}]', GrupoController::class . ':add')->add(PermissionMiddleware::class)->setName('GrupoAdd-grupo-add'); // add
    $app->any('/GrupoDelete[/{id_grupo}]', GrupoController::class . ':delete')->add(PermissionMiddleware::class)->setName('GrupoDelete-grupo-delete'); // delete
    $app->any('/GrupoPreview', GrupoController::class . ':preview')->add(PermissionMiddleware::class)->setName('GrupoPreview-grupo-preview'); // preview
    $app->group(
        '/grupo',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_grupo}]', GrupoController::class . ':list')->add(PermissionMiddleware::class)->setName('grupo/list-grupo-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_grupo}]', GrupoController::class . ':add')->add(PermissionMiddleware::class)->setName('grupo/add-grupo-add-2'); // add
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_grupo}]', GrupoController::class . ':delete')->add(PermissionMiddleware::class)->setName('grupo/delete-grupo-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', GrupoController::class . ':preview')->add(PermissionMiddleware::class)->setName('grupo/preview-grupo-preview-2'); // preview
        }
    );

    // participantes
    $app->any('/ParticipantesList[/{id_participantes}]', ParticipantesController::class . ':list')->add(PermissionMiddleware::class)->setName('ParticipantesList-participantes-list'); // list
    $app->any('/ParticipantesAdd[/{id_participantes}]', ParticipantesController::class . ':add')->add(PermissionMiddleware::class)->setName('ParticipantesAdd-participantes-add'); // add
    $app->any('/ParticipantesView[/{id_participantes}]', ParticipantesController::class . ':view')->add(PermissionMiddleware::class)->setName('ParticipantesView-participantes-view'); // view
    $app->any('/ParticipantesEdit[/{id_participantes}]', ParticipantesController::class . ':edit')->add(PermissionMiddleware::class)->setName('ParticipantesEdit-participantes-edit'); // edit
    $app->any('/ParticipantesDelete[/{id_participantes}]', ParticipantesController::class . ':delete')->add(PermissionMiddleware::class)->setName('ParticipantesDelete-participantes-delete'); // delete
    $app->group(
        '/participantes',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_participantes}]', ParticipantesController::class . ':list')->add(PermissionMiddleware::class)->setName('participantes/list-participantes-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_participantes}]', ParticipantesController::class . ':add')->add(PermissionMiddleware::class)->setName('participantes/add-participantes-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_participantes}]', ParticipantesController::class . ':view')->add(PermissionMiddleware::class)->setName('participantes/view-participantes-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_participantes}]', ParticipantesController::class . ':edit')->add(PermissionMiddleware::class)->setName('participantes/edit-participantes-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_participantes}]', ParticipantesController::class . ':delete')->add(PermissionMiddleware::class)->setName('participantes/delete-participantes-delete-2'); // delete
        }
    );

    // subgrupo
    $app->any('/SubgrupoList[/{id_subgrupo}]', SubgrupoController::class . ':list')->add(PermissionMiddleware::class)->setName('SubgrupoList-subgrupo-list'); // list
    $app->any('/SubgrupoAdd[/{id_subgrupo}]', SubgrupoController::class . ':add')->add(PermissionMiddleware::class)->setName('SubgrupoAdd-subgrupo-add'); // add
    $app->any('/SubgrupoEdit[/{id_subgrupo}]', SubgrupoController::class . ':edit')->add(PermissionMiddleware::class)->setName('SubgrupoEdit-subgrupo-edit'); // edit
    $app->any('/SubgrupoDelete[/{id_subgrupo}]', SubgrupoController::class . ':delete')->add(PermissionMiddleware::class)->setName('SubgrupoDelete-subgrupo-delete'); // delete
    $app->any('/SubgrupoPreview', SubgrupoController::class . ':preview')->add(PermissionMiddleware::class)->setName('SubgrupoPreview-subgrupo-preview'); // preview
    $app->group(
        '/subgrupo',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_subgrupo}]', SubgrupoController::class . ':list')->add(PermissionMiddleware::class)->setName('subgrupo/list-subgrupo-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_subgrupo}]', SubgrupoController::class . ':add')->add(PermissionMiddleware::class)->setName('subgrupo/add-subgrupo-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_subgrupo}]', SubgrupoController::class . ':edit')->add(PermissionMiddleware::class)->setName('subgrupo/edit-subgrupo-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_subgrupo}]', SubgrupoController::class . ':delete')->add(PermissionMiddleware::class)->setName('subgrupo/delete-subgrupo-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', SubgrupoController::class . ':preview')->add(PermissionMiddleware::class)->setName('subgrupo/preview-subgrupo-preview-2'); // preview
        }
    );

    // tareas
    $app->any('/TareasList[/{id_tarea}]', TareasController::class . ':list')->add(PermissionMiddleware::class)->setName('TareasList-tareas-list'); // list
    $app->any('/TareasAdd[/{id_tarea}]', TareasController::class . ':add')->add(PermissionMiddleware::class)->setName('TareasAdd-tareas-add'); // add
    $app->any('/TareasEdit[/{id_tarea}]', TareasController::class . ':edit')->add(PermissionMiddleware::class)->setName('TareasEdit-tareas-edit'); // edit
    $app->any('/TareasDelete[/{id_tarea}]', TareasController::class . ':delete')->add(PermissionMiddleware::class)->setName('TareasDelete-tareas-delete'); // delete
    $app->any('/TareasPreview', TareasController::class . ':preview')->add(PermissionMiddleware::class)->setName('TareasPreview-tareas-preview'); // preview
    $app->group(
        '/tareas',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_tarea}]', TareasController::class . ':list')->add(PermissionMiddleware::class)->setName('tareas/list-tareas-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_tarea}]', TareasController::class . ':add')->add(PermissionMiddleware::class)->setName('tareas/add-tareas-add-2'); // add
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_tarea}]', TareasController::class . ':edit')->add(PermissionMiddleware::class)->setName('tareas/edit-tareas-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_tarea}]', TareasController::class . ':delete')->add(PermissionMiddleware::class)->setName('tareas/delete-tareas-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', TareasController::class . ':preview')->add(PermissionMiddleware::class)->setName('tareas/preview-tareas-preview-2'); // preview
        }
    );

    // inicio
    $app->any('/Inicio[/{params:.*}]', InicioController::class)->add(PermissionMiddleware::class)->setName('Inicio-inicio-custom'); // custom

    // paisgmt
    $app->any('/PaisgmtList[/{id_zone}]', PaisgmtController::class . ':list')->add(PermissionMiddleware::class)->setName('PaisgmtList-paisgmt-list'); // list
    $app->any('/PaisgmtAdd[/{id_zone}]', PaisgmtController::class . ':add')->add(PermissionMiddleware::class)->setName('PaisgmtAdd-paisgmt-add'); // add
    $app->any('/PaisgmtView[/{id_zone}]', PaisgmtController::class . ':view')->add(PermissionMiddleware::class)->setName('PaisgmtView-paisgmt-view'); // view
    $app->any('/PaisgmtEdit[/{id_zone}]', PaisgmtController::class . ':edit')->add(PermissionMiddleware::class)->setName('PaisgmtEdit-paisgmt-edit'); // edit
    $app->any('/PaisgmtDelete[/{id_zone}]', PaisgmtController::class . ':delete')->add(PermissionMiddleware::class)->setName('PaisgmtDelete-paisgmt-delete'); // delete
    $app->group(
        '/paisgmt',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':list')->add(PermissionMiddleware::class)->setName('paisgmt/list-paisgmt-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':add')->add(PermissionMiddleware::class)->setName('paisgmt/add-paisgmt-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':view')->add(PermissionMiddleware::class)->setName('paisgmt/view-paisgmt-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':edit')->add(PermissionMiddleware::class)->setName('paisgmt/edit-paisgmt-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_zone}]', PaisgmtController::class . ':delete')->add(PermissionMiddleware::class)->setName('paisgmt/delete-paisgmt-delete-2'); // delete
        }
    );

    // correo
    $app->any('/Correo[/{params:.*}]', CorreoController::class)->add(PermissionMiddleware::class)->setName('Correo-correo-custom'); // custom

    // email2
    $app->any('/Email2List[/{id_email}]', Email2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('Email2List-email2-list'); // list
    $app->any('/Email2Add[/{id_email}]', Email2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('Email2Add-email2-add'); // add
    $app->any('/Email2View[/{id_email}]', Email2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('Email2View-email2-view'); // view
    $app->any('/Email2Edit[/{id_email}]', Email2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('Email2Edit-email2-edit'); // edit
    $app->any('/Email2Delete[/{id_email}]', Email2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('Email2Delete-email2-delete'); // delete
    $app->group(
        '/email2',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_email}]', Email2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('email2/list-email2-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_email}]', Email2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('email2/add-email2-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_email}]', Email2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('email2/view-email2-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_email}]', Email2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('email2/edit-email2-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_email}]', Email2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('email2/delete-email2-delete-2'); // delete
        }
    );

    // users
    $app->any('/UsersList[/{id_users}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('UsersList-users-list'); // list
    $app->any('/UsersAdd[/{id_users}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('UsersAdd-users-add'); // add
    $app->any('/UsersView[/{id_users}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('UsersView-users-view'); // view
    $app->any('/UsersEdit[/{id_users}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('UsersEdit-users-edit'); // edit
    $app->any('/UsersDelete[/{id_users}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('UsersDelete-users-delete'); // delete
    $app->group(
        '/users',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_users}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('users/list-users-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_users}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('users/add-users-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_users}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('users/view-users-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_users}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('users/edit-users-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_users}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('users/delete-users-delete-2'); // delete
        }
    );

    // mensagens
    $app->any('/MensagensList[/{id}]', MensagensController::class . ':list')->add(PermissionMiddleware::class)->setName('MensagensList-mensagens-list'); // list
    $app->any('/MensagensAdd[/{id}]', MensagensController::class . ':add')->add(PermissionMiddleware::class)->setName('MensagensAdd-mensagens-add'); // add
    $app->any('/MensagensView[/{id}]', MensagensController::class . ':view')->add(PermissionMiddleware::class)->setName('MensagensView-mensagens-view'); // view
    $app->any('/MensagensEdit[/{id}]', MensagensController::class . ':edit')->add(PermissionMiddleware::class)->setName('MensagensEdit-mensagens-edit'); // edit
    $app->any('/MensagensDelete[/{id}]', MensagensController::class . ':delete')->add(PermissionMiddleware::class)->setName('MensagensDelete-mensagens-delete'); // delete
    $app->group(
        '/mensagens',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MensagensController::class . ':list')->add(PermissionMiddleware::class)->setName('mensagens/list-mensagens-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MensagensController::class . ':add')->add(PermissionMiddleware::class)->setName('mensagens/add-mensagens-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MensagensController::class . ':view')->add(PermissionMiddleware::class)->setName('mensagens/view-mensagens-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MensagensController::class . ':edit')->add(PermissionMiddleware::class)->setName('mensagens/edit-mensagens-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MensagensController::class . ':delete')->add(PermissionMiddleware::class)->setName('mensagens/delete-mensagens-delete-2'); // delete
        }
    );

    // incidente
    $app->any('/IncidenteList[/{id_incidente}]', IncidenteController::class . ':list')->add(PermissionMiddleware::class)->setName('IncidenteList-incidente-list'); // list
    $app->any('/IncidenteAdd[/{id_incidente}]', IncidenteController::class . ':add')->add(PermissionMiddleware::class)->setName('IncidenteAdd-incidente-add'); // add
    $app->any('/IncidenteView[/{id_incidente}]', IncidenteController::class . ':view')->add(PermissionMiddleware::class)->setName('IncidenteView-incidente-view'); // view
    $app->any('/IncidenteEdit[/{id_incidente}]', IncidenteController::class . ':edit')->add(PermissionMiddleware::class)->setName('IncidenteEdit-incidente-edit'); // edit
    $app->any('/IncidenteDelete[/{id_incidente}]', IncidenteController::class . ':delete')->add(PermissionMiddleware::class)->setName('IncidenteDelete-incidente-delete'); // delete
    $app->group(
        '/incidente',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':list')->add(PermissionMiddleware::class)->setName('incidente/list-incidente-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':add')->add(PermissionMiddleware::class)->setName('incidente/add-incidente-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':view')->add(PermissionMiddleware::class)->setName('incidente/view-incidente-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':edit')->add(PermissionMiddleware::class)->setName('incidente/edit-incidente-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_incidente}]', IncidenteController::class . ':delete')->add(PermissionMiddleware::class)->setName('incidente/delete-incidente-delete-2'); // delete
        }
    );

    // tipo
    $app->any('/TipoList[/{id_tipo}]', TipoController::class . ':list')->add(PermissionMiddleware::class)->setName('TipoList-tipo-list'); // list
    $app->any('/TipoAdd[/{id_tipo}]', TipoController::class . ':add')->add(PermissionMiddleware::class)->setName('TipoAdd-tipo-add'); // add
    $app->any('/TipoView[/{id_tipo}]', TipoController::class . ':view')->add(PermissionMiddleware::class)->setName('TipoView-tipo-view'); // view
    $app->any('/TipoEdit[/{id_tipo}]', TipoController::class . ':edit')->add(PermissionMiddleware::class)->setName('TipoEdit-tipo-edit'); // edit
    $app->any('/TipoDelete[/{id_tipo}]', TipoController::class . ':delete')->add(PermissionMiddleware::class)->setName('TipoDelete-tipo-delete'); // delete
    $app->group(
        '/tipo',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_tipo}]', TipoController::class . ':list')->add(PermissionMiddleware::class)->setName('tipo/list-tipo-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_tipo}]', TipoController::class . ':add')->add(PermissionMiddleware::class)->setName('tipo/add-tipo-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_tipo}]', TipoController::class . ':view')->add(PermissionMiddleware::class)->setName('tipo/view-tipo-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_tipo}]', TipoController::class . ':edit')->add(PermissionMiddleware::class)->setName('tipo/edit-tipo-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_tipo}]', TipoController::class . ':delete')->add(PermissionMiddleware::class)->setName('tipo/delete-tipo-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->any('/UserlevelpermissionsList[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsList-userlevelpermissions-list'); // list
    $app->any('/UserlevelpermissionsAdd[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsAdd-userlevelpermissions-add'); // add
    $app->any('/UserlevelpermissionsView[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsView-userlevelpermissions-view'); // view
    $app->any('/UserlevelpermissionsEdit[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsEdit-userlevelpermissions-edit'); // edit
    $app->any('/UserlevelpermissionsDelete[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelpermissionsDelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // userlevels
    $app->any('/UserlevelsList[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('UserlevelsList-userlevels-list'); // list
    $app->any('/UserlevelsAdd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('UserlevelsAdd-userlevels-add'); // add
    $app->any('/UserlevelsView[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('UserlevelsView-userlevels-view'); // view
    $app->any('/UserlevelsEdit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserlevelsEdit-userlevels-edit'); // edit
    $app->any('/UserlevelsDelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserlevelsDelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // audittrail
    $app->any('/AudittrailList[/{id}]', AudittrailController::class . ':list')->add(PermissionMiddleware::class)->setName('AudittrailList-audittrail-list'); // list
    $app->any('/AudittrailAdd[/{id}]', AudittrailController::class . ':add')->add(PermissionMiddleware::class)->setName('AudittrailAdd-audittrail-add'); // add
    $app->any('/AudittrailView[/{id}]', AudittrailController::class . ':view')->add(PermissionMiddleware::class)->setName('AudittrailView-audittrail-view'); // view
    $app->any('/AudittrailEdit[/{id}]', AudittrailController::class . ':edit')->add(PermissionMiddleware::class)->setName('AudittrailEdit-audittrail-edit'); // edit
    $app->any('/AudittrailDelete[/{id}]', AudittrailController::class . ':delete')->add(PermissionMiddleware::class)->setName('AudittrailDelete-audittrail-delete'); // delete
    $app->group(
        '/audittrail',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', AudittrailController::class . ':list')->add(PermissionMiddleware::class)->setName('audittrail/list-audittrail-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', AudittrailController::class . ':add')->add(PermissionMiddleware::class)->setName('audittrail/add-audittrail-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', AudittrailController::class . ':view')->add(PermissionMiddleware::class)->setName('audittrail/view-audittrail-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', AudittrailController::class . ':edit')->add(PermissionMiddleware::class)->setName('audittrail/edit-audittrail-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', AudittrailController::class . ':delete')->add(PermissionMiddleware::class)->setName('audittrail/delete-audittrail-delete-2'); // delete
        }
    );

    // menucontenedor
    $app->any('/Menucontenedor[/{params:.*}]', MenucontenedorController::class)->add(PermissionMiddleware::class)->setName('Menucontenedor-menucontenedor-custom'); // custom

    // mensajes
    $app->any('/MensajesList[/{id_inyect}]', MensajesController::class . ':list')->add(PermissionMiddleware::class)->setName('MensajesList-mensajes-list'); // list
    $app->any('/MensajesAdd[/{id_inyect}]', MensajesController::class . ':add')->add(PermissionMiddleware::class)->setName('MensajesAdd-mensajes-add'); // add
    $app->any('/MensajesView[/{id_inyect}]', MensajesController::class . ':view')->add(PermissionMiddleware::class)->setName('MensajesView-mensajes-view'); // view
    $app->any('/MensajesEdit[/{id_inyect}]', MensajesController::class . ':edit')->add(PermissionMiddleware::class)->setName('MensajesEdit-mensajes-edit'); // edit
    $app->any('/MensajesDelete[/{id_inyect}]', MensajesController::class . ':delete')->add(PermissionMiddleware::class)->setName('MensajesDelete-mensajes-delete'); // delete
    $app->any('/MensajesPreview', MensajesController::class . ':preview')->add(PermissionMiddleware::class)->setName('MensajesPreview-mensajes-preview'); // preview
    $app->group(
        '/mensajes',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_inyect}]', MensajesController::class . ':list')->add(PermissionMiddleware::class)->setName('mensajes/list-mensajes-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_inyect}]', MensajesController::class . ':add')->add(PermissionMiddleware::class)->setName('mensajes/add-mensajes-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_inyect}]', MensajesController::class . ':view')->add(PermissionMiddleware::class)->setName('mensajes/view-mensajes-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_inyect}]', MensajesController::class . ':edit')->add(PermissionMiddleware::class)->setName('mensajes/edit-mensajes-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_inyect}]', MensajesController::class . ':delete')->add(PermissionMiddleware::class)->setName('mensajes/delete-mensajes-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', MensajesController::class . ':preview')->add(PermissionMiddleware::class)->setName('mensajes/preview-mensajes-preview-2'); // preview
        }
    );

    // chat_ini
    $app->any('/ChatIni[/{params:.*}]', ChatIniController::class)->add(PermissionMiddleware::class)->setName('ChatIni-chat_ini-custom'); // custom

    // todos
    $app->any('/TodosList[/{id}]', TodosController::class . ':list')->add(PermissionMiddleware::class)->setName('TodosList-todos-list'); // list
    $app->any('/TodosAdd[/{id}]', TodosController::class . ':add')->add(PermissionMiddleware::class)->setName('TodosAdd-todos-add'); // add
    $app->any('/TodosView[/{id}]', TodosController::class . ':view')->add(PermissionMiddleware::class)->setName('TodosView-todos-view'); // view
    $app->any('/TodosEdit[/{id}]', TodosController::class . ':edit')->add(PermissionMiddleware::class)->setName('TodosEdit-todos-edit'); // edit
    $app->any('/TodosDelete[/{id}]', TodosController::class . ':delete')->add(PermissionMiddleware::class)->setName('TodosDelete-todos-delete'); // delete
    $app->group(
        '/todos',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', TodosController::class . ':list')->add(PermissionMiddleware::class)->setName('todos/list-todos-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', TodosController::class . ':add')->add(PermissionMiddleware::class)->setName('todos/add-todos-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', TodosController::class . ':view')->add(PermissionMiddleware::class)->setName('todos/view-todos-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', TodosController::class . ':edit')->add(PermissionMiddleware::class)->setName('todos/edit-todos-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', TodosController::class . ':delete')->add(PermissionMiddleware::class)->setName('todos/delete-todos-delete-2'); // delete
        }
    );

    // view_from
    $app->any('/ViewFromList', ViewFromController::class . ':list')->add(PermissionMiddleware::class)->setName('ViewFromList-view_from-list'); // list
    $app->group(
        '/view_from',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', ViewFromController::class . ':list')->add(PermissionMiddleware::class)->setName('view_from/list-view_from-list-2'); // list
        }
    );

    // historico
    $app->any('/Historico[/{params:.*}]', HistoricoController::class)->add(PermissionMiddleware::class)->setName('Historico-historico-custom'); // custom

    // actor_simulado
    $app->any('/ActorSimuladoList[/{id_actor}]', ActorSimuladoController::class . ':list')->add(PermissionMiddleware::class)->setName('ActorSimuladoList-actor_simulado-list'); // list
    $app->any('/ActorSimuladoAdd[/{id_actor}]', ActorSimuladoController::class . ':add')->add(PermissionMiddleware::class)->setName('ActorSimuladoAdd-actor_simulado-add'); // add
    $app->any('/ActorSimuladoAddopt', ActorSimuladoController::class . ':addopt')->add(PermissionMiddleware::class)->setName('ActorSimuladoAddopt-actor_simulado-addopt'); // addopt
    $app->any('/ActorSimuladoView[/{id_actor}]', ActorSimuladoController::class . ':view')->add(PermissionMiddleware::class)->setName('ActorSimuladoView-actor_simulado-view'); // view
    $app->any('/ActorSimuladoEdit[/{id_actor}]', ActorSimuladoController::class . ':edit')->add(PermissionMiddleware::class)->setName('ActorSimuladoEdit-actor_simulado-edit'); // edit
    $app->any('/ActorSimuladoDelete[/{id_actor}]', ActorSimuladoController::class . ':delete')->add(PermissionMiddleware::class)->setName('ActorSimuladoDelete-actor_simulado-delete'); // delete
    $app->group(
        '/actor_simulado',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':list')->add(PermissionMiddleware::class)->setName('actor_simulado/list-actor_simulado-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':add')->add(PermissionMiddleware::class)->setName('actor_simulado/add-actor_simulado-add-2'); // add
            $group->any('/' . Config("ADDOPT_ACTION") . '', ActorSimuladoController::class . ':addopt')->add(PermissionMiddleware::class)->setName('actor_simulado/addopt-actor_simulado-addopt-2'); // addopt
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':view')->add(PermissionMiddleware::class)->setName('actor_simulado/view-actor_simulado-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':edit')->add(PermissionMiddleware::class)->setName('actor_simulado/edit-actor_simulado-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_actor}]', ActorSimuladoController::class . ':delete')->add(PermissionMiddleware::class)->setName('actor_simulado/delete-actor_simulado-delete-2'); // delete
        }
    );

    // mensajes_usuarios
    $app->any('/MensajesUsuariosList[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':list')->add(PermissionMiddleware::class)->setName('MensajesUsuariosList-mensajes_usuarios-list'); // list
    $app->any('/MensajesUsuariosAdd[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':add')->add(PermissionMiddleware::class)->setName('MensajesUsuariosAdd-mensajes_usuarios-add'); // add
    $app->any('/MensajesUsuariosView[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':view')->add(PermissionMiddleware::class)->setName('MensajesUsuariosView-mensajes_usuarios-view'); // view
    $app->any('/MensajesUsuariosEdit[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':edit')->add(PermissionMiddleware::class)->setName('MensajesUsuariosEdit-mensajes_usuarios-edit'); // edit
    $app->any('/MensajesUsuariosDelete[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':delete')->add(PermissionMiddleware::class)->setName('MensajesUsuariosDelete-mensajes_usuarios-delete'); // delete
    $app->group(
        '/mensajes_usuarios',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':list')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/list-mensajes_usuarios-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':add')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/add-mensajes_usuarios-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':view')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/view-mensajes_usuarios-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':edit')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/edit-mensajes_usuarios-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_mensaje_usuario}]', MensajesUsuariosController::class . ':delete')->add(PermissionMiddleware::class)->setName('mensajes_usuarios/delete-mensajes_usuarios-delete-2'); // delete
        }
    );

    // grupos
    $app->any('/Grupos[/{params:.*}]', GruposController::class)->add(PermissionMiddleware::class)->setName('Grupos-grupos-custom'); // custom

    // onlyoffice
    $app->any('/Onlyoffice[/{params:.*}]', OnlyofficeController::class)->add(PermissionMiddleware::class)->setName('Onlyoffice-onlyoffice-custom'); // custom

    // timeline
    $app->any('/Timeline[/{params:.*}]', TimelineController::class)->add(PermissionMiddleware::class)->setName('Timeline-timeline-custom'); // custom

    // archivos_doc
    $app->any('/ArchivosDocList[/{id_file}]', ArchivosDocController::class . ':list')->add(PermissionMiddleware::class)->setName('ArchivosDocList-archivos_doc-list'); // list
    $app->any('/ArchivosDocAdd[/{id_file}]', ArchivosDocController::class . ':add')->add(PermissionMiddleware::class)->setName('ArchivosDocAdd-archivos_doc-add'); // add
    $app->any('/ArchivosDocView[/{id_file}]', ArchivosDocController::class . ':view')->add(PermissionMiddleware::class)->setName('ArchivosDocView-archivos_doc-view'); // view
    $app->any('/ArchivosDocEdit[/{id_file}]', ArchivosDocController::class . ':edit')->add(PermissionMiddleware::class)->setName('ArchivosDocEdit-archivos_doc-edit'); // edit
    $app->any('/ArchivosDocDelete[/{id_file}]', ArchivosDocController::class . ':delete')->add(PermissionMiddleware::class)->setName('ArchivosDocDelete-archivos_doc-delete'); // delete
    $app->group(
        '/archivos_doc',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':list')->add(PermissionMiddleware::class)->setName('archivos_doc/list-archivos_doc-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':add')->add(PermissionMiddleware::class)->setName('archivos_doc/add-archivos_doc-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':view')->add(PermissionMiddleware::class)->setName('archivos_doc/view-archivos_doc-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':edit')->add(PermissionMiddleware::class)->setName('archivos_doc/edit-archivos_doc-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_file}]', ArchivosDocController::class . ':delete')->add(PermissionMiddleware::class)->setName('archivos_doc/delete-archivos_doc-delete-2'); // delete
        }
    );

    // permisos_doc
    $app->any('/PermisosDocList[/{id_permiso}]', PermisosDocController::class . ':list')->add(PermissionMiddleware::class)->setName('PermisosDocList-permisos_doc-list'); // list
    $app->any('/PermisosDocAdd[/{id_permiso}]', PermisosDocController::class . ':add')->add(PermissionMiddleware::class)->setName('PermisosDocAdd-permisos_doc-add'); // add
    $app->any('/PermisosDocView[/{id_permiso}]', PermisosDocController::class . ':view')->add(PermissionMiddleware::class)->setName('PermisosDocView-permisos_doc-view'); // view
    $app->any('/PermisosDocEdit[/{id_permiso}]', PermisosDocController::class . ':edit')->add(PermissionMiddleware::class)->setName('PermisosDocEdit-permisos_doc-edit'); // edit
    $app->any('/PermisosDocDelete[/{id_permiso}]', PermisosDocController::class . ':delete')->add(PermissionMiddleware::class)->setName('PermisosDocDelete-permisos_doc-delete'); // delete
    $app->any('/PermisosDocPreview', PermisosDocController::class . ':preview')->add(PermissionMiddleware::class)->setName('PermisosDocPreview-permisos_doc-preview'); // preview
    $app->group(
        '/permisos_doc',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':list')->add(PermissionMiddleware::class)->setName('permisos_doc/list-permisos_doc-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':add')->add(PermissionMiddleware::class)->setName('permisos_doc/add-permisos_doc-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':view')->add(PermissionMiddleware::class)->setName('permisos_doc/view-permisos_doc-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':edit')->add(PermissionMiddleware::class)->setName('permisos_doc/edit-permisos_doc-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id_permiso}]', PermisosDocController::class . ':delete')->add(PermissionMiddleware::class)->setName('permisos_doc/delete-permisos_doc-delete-2'); // delete
            $group->any('/' . Config("PREVIEW_ACTION") . '', PermisosDocController::class . ':preview')->add(PermissionMiddleware::class)->setName('permisos_doc/preview-permisos_doc-preview-2'); // preview
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // change_password
    $app->any('/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // userpriv
    $app->any('/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
