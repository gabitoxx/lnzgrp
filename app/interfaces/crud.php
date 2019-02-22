<?php
namespace app\interfaces;
defined("APPPATH") OR die("Access denied");
 
interface crud
{
	public static function getAll();

	public static function getById($id);

	public static function getUserObjectById($id);

	public static function getUser($username, $password, $activo);

	public static function insert($greetings, $givenname, $lastname, $gender,
			$email, $username, $password,
			$empresaId, $dependencia, $cargo,
			$cellphone_code, $phone_cell, $phone_home, $phone_work, $phone_work_ext,
			$activo, $birthdate);

	public static function update($userId, $greetings, $givenname, $lastname, $gender,
			$email, $dependencia, 
			$cellphone_code, $phone_cell, $phone_home, $phone_work, $phone_work_ext,
			$birthdate);

	public static function updatePassword($userName, $pwdActual, $pwdNuevo);

	public static function delete($id);


	public static function setPreferenciasDefault($user);


	public static function nuevoUsuarioEstatus($userId);
	
	public static function getUsuarioEstatus($userId);


	public static function getUserByEmailOrUsername($forgetPassword);

	public static function getUsuariosDeEmpresa($empresaId, $ordenadoPorNombre);
	
	public static function getTecnicoById($tecnicoId);

	public static function getUserIdByEquipoId($equipoId);


	public static function yaExisteEsteCampo( $campoAvalidar, $valorAvalidar );

	public static function getProfile($id);

	public static function getManagersDeEmpresa($empresaId);


	public static function searchUsers($givenOrLastNameOrEmailOrCompanyName);

	public static function searchUsers2($literalStringToSearch);

	public static function cambiarStatus($userId, $role);
}