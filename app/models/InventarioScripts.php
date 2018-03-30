<?php
namespace app\models;
defined("APPPATH") OR die("Access denied");

use \app\models\Equipos,
	\app\models\Utils;

/**
 * Clase que leerá los Archivos .CSV del Inventario de los Equipos
 *  archivos generados por el SCRIPT
 */
class InventarioScripts {

	/**
	 * Leyendo archivo .CSV: CPU
	 * @param $equipoId ID A_I del Equipo
	 * @return Array[2]: 0.- el ID | 1.- info resultado para el Tecnico
	 */
	public static function csvCPU($contenidoArchivo, $equipoId){
		try {
			$cpu="";
			$i=0;

			$a="";
			$AddressWidth="";$CurrentClockSpeed="";$L2CacheSize="";
			$L3CacheSize="";$Name="";$NumberOfCores="";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);

			$auxArray = NULL;

			foreach ( $array as $linea ){
				//acciones
				$i++;
				if ( $linea != NULL && $linea != "" ){
					/* $cpu .= "<br>i:".$i."--".$linea .";"; */

					if ( Utils::startsWith($linea, "AddressWidth") ){
						$auxArray = explode(",", $linea);
						$AddressWidth = $auxArray[1];

					} else if ( Utils::startsWith($linea, "CurrentClockSpeed") ){
						$auxArray = explode(",", $linea);
						$CurrentClockSpeed = $auxArray[1];

					} else if ( Utils::startsWith($linea, "L2CacheSize") ){
					 	$auxArray = explode(",", $linea);
						$L2CacheSize = $auxArray[1];

					} else if ( Utils::startsWith($linea, "L3CacheSize") ){
						$auxArray = explode(",", $linea);
						$L3CacheSize = $auxArray[1];

					} else if ( Utils::startsWith($linea, "Name") ){
					 	$auxArray = explode(",", $linea);
						$Name = $auxArray[1];

					} else if ( Utils::startsWith($linea, "NumberOfCores") ){
					 	$auxArray = explode(",", $linea);
						$NumberOfCores = $auxArray[1];
					}

					/* Los delimitadores pueden ser barra, punto o guión
					$fecha = "04/30/1973";
					list($mes, $día, $año) = split('[/.-]', $fecha);
					*/
				}
			}

			$cpu .= "<br/>Resumen de CPU.csv: "
				. "<br/>Nombre: $Name"
				. "<br/>Número de Núcleos: $NumberOfCores"
				. "<br/>Máquina de $AddressWidth bits.";

			/*
			 * Insertar esta data en tabla ICPU y obtener su id A_I
			 */
			$maxID = Equipos::getMaxID("ICPU");
			$maxID++;
			$count = Equipos::insertarCPU($maxID, $AddressWidth, $CurrentClockSpeed, $L2CacheSize, 
					$L3CacheSize, $Name, $NumberOfCores, -1);

			$out['cpuId']   = $maxID;
			$out['count']   = $count;
			$out['resumen'] = $cpu;

			/*
			 * Actualizar la info basica del Equipo
			 */
			$texto = $Name;
			if ( $NumberOfCores == 1 ){
				$texto .= ", 1 Núcleo";
			} else {
				$texto .= ", $NumberOfCores Núcleos";
			}

			Equipos::actualizarInfoBasica($equipoId, $texto, "concat");
			
			return $out;

		} catch (\Exception $e) {
			$out['cpuId']   = -1;
			$out['resumen'] =  $e -> getMessage();
			return $out;
		}
	}


	/**
	 * Leyendo archivo .CSV: Motherboard
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Motherboard']['tmp_name']
	 * @param $file_name 		$_FILES['Motherboard']['name']
	 * @param $file_size 		$_FILES["Motherboard"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array[2]: 0.- el ID a tabla IMotherboard | 1.- info resultado para el Tecnico
	 */
	public static function csvMotherboard($equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber){
		try {
			$mb1 = "<br><b>Archivo 2: " . $file_name . "</b>";

			$mb1 .= "<br>Tamaño: " . $file_size . " bytes";

			$mb1 .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$mb1 .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);

			$auxArray = NULL;

			$a="";
			$Name="";$Product="";$SerialNumber="";$Version="";
			$i=0;
			foreach ( $array as $linea ){
				$i++;
				if ( $linea != NULL && $linea != "" ){
					
					if ( Utils::startsWith($linea, "Name") ){
						$auxArray = explode(",", $linea);
						$Name = $auxArray[1];

					} else if ( Utils::startsWith($linea, "Product") ){
						$auxArray = explode(",", $linea);
						$Product = $auxArray[1];

					} else if ( Utils::startsWith($linea, "SerialNumber") ){
						$auxArray = explode(",", $linea);
						$SerialNumber = $auxArray[1];

					} else if ( Utils::startsWith($linea, "Version") ){
						$auxArray = explode(",", $linea);
						$Version = $auxArray[1];
					}
				}
			}

			$mb2 = "<br/>Resumen de Motherboard.csv: "
				. "<br/>Nombre: $Name"
				. "<br/>Serial: $SerialNumber"
				. "<br/>Version: $Version";

			$maxID = Equipos::getMaxID("IMotherBoard");
			$maxID++;

			$count = Equipos::insertarMotherboard($maxID, $Name, $Product, $SerialNumber, $Version, $legacyNumber);

			if ( $count == 1 ){
				$mb1 .= "<br><b>...¡Procesado correctamente!</b>";
			} else {
				$mb1 .= "<br><b>...Archivo NO procesado</b>: " . $count;
			}

			$out['info'] 	= $mb1;
			$out['mbId']    = $maxID;
			$out['resumen'] = $mb2;

			return $out;

		} catch ( \Exception $e ) {
			$out['info']    = "<br/><b>NO se pudo procesar el Archivo 2: Motherboard.csv</b>";
			$out['mbId']    = -1;
			$out['resumen'] =  $e -> getMessage();
			return $out;
		}
	}


	/**
	 * Leyendo archivo .CSV: LocalUsers
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['LocalUsers']['tmp_name']
	 * @param $file_name 		$_FILES['LocalUsers']['name']
	 * @param $file_size 		$_FILES["LocalUsers"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvLocalUsers( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber ){
		try {
			$result = "<br><b>Archivo 4: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;

			$a="";
			$Name="";$Type="";
			$arrayName[0]="";$arrayType[0]="";

			$i=0;$j=0;
			foreach ( $array as $linea ){
				if ( $linea != NULL && $linea != "" ){
					
					if ( Utils::startsWith($linea, "Name") ){

						$auxArray = explode(",", $linea);
						$Name = $auxArray[1];

						$arrayName[$i] = $Name;
						$i++;

					} else if ( Utils::startsWith($linea, "Type") ){

						$auxArray = explode(",", $linea);
						$Type = $auxArray[1];

						$arrayType[$j] = $Type;
						$j++;
					}
				}
			}

			$result .= "<br/>Resumen de LocalUsers.csv: "
				. "<br/>Cantidad de Cuentas que tiene este Equipo: $i";

			$result .= "<br/>" . Equipos::insertarLocalUsers($equipoInfoId, $i, $arrayName, $j, $arrayType, $legacyNumber);

			return $result;

		} catch ( \Exception $e ) {
			return "<br/><b>NO se pudo procesar el Archivo 4: LocalUsers.csv</b>. Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Leyendo archivo .CSV: RAM
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['RAM']['tmp_name']
	 * @param $file_name 		$_FILES['RAM']['name']
	 * @param $file_size 		$_FILES["RAM"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvRAM( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber ){
		try {
			$result = "<br><b>Archivo 3: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;

			$a="";
			$BankLabel="";$Capacity="";$ConfiguredClockSpeed="";$MemoryType="";$Speed="";
			$arrayBankLabel[0]="";$arrayCapacity[0]="";$arrayCCS[0]="";$arrayMemoryType[0]="";$arraySpeed[0]="";

			$i=0;$j=0;$k=0;$l=0;$m=0;
			foreach ( $array as $linea ){
				if ( $linea != NULL && $linea != "" ){
					
					if ( Utils::startsWith($linea, "BankLabel") ){

						$auxArray = explode(",", $linea);
						$BankLabel = $auxArray[1];

						$arrayBankLabel[$i] = $BankLabel;
						$i++;

					} else if ( Utils::startsWith($linea, "Capacity") ){

						$auxArray = explode(",", $linea);
						$Capacity = $auxArray[1];

						$arrayCapacity[$j] = $Capacity;
						$j++;

					} else if ( Utils::startsWith($linea, "ConfiguredClockSpeed") ){

						$auxArray = explode(",", $linea);
						$ConfiguredClockSpeed = $auxArray[1];

						$arrayCCS[$k] = $ConfiguredClockSpeed;
						$k++;

					} else if ( Utils::startsWith($linea, "MemoryType") ){

						$auxArray = explode(",", $linea);
						$MemoryType = $auxArray[1];

						$arrayMemoryType[$l] = $MemoryType;
						$l++;

					} else if ( Utils::startsWith($linea, "Speed") ){

						$auxArray = explode(",", $linea);
						$Speed = $auxArray[1];

						$arraySpeed[$m] = $Speed;
						$m++;
					}
				}
			}

			$result .= "<br/>Resumen de RAM.csv: "
					. "<br/>Cantidad de slots RAM que tiene este Equipo: $i";
			
			if ( $k == 0 ){
				$arrayCCS = NULL;
			}

			$result .= "<br/>" . Equipos::insertarRAM($equipoInfoId, $arrayBankLabel, $arrayCapacity, 
					$arrayCCS, $arrayMemoryType, $arraySpeed, $legacyNumber);

			return $result;

		} catch ( \Exception $e ) {
			return "<br/><b>NO se pudo procesar el Archivo 3: RAM.csv</b>. Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Leyendo archivo .CSV: Sound
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Sound']['tmp_name']
	 * @param $file_name 		$_FILES['Sound']['name']
	 * @param $file_size 		$_FILES["Sound"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvSound( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber ){
		try {
			$result = "<br><b>Archivo 5: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;

			$a="";
			$Caption="";$Manufacturer="";
			$arrayCaption[0]="";$arrayManufacturer[0]="";

			$i=0;$j=0;
			foreach ( $array as $linea ){
				if ( $linea != NULL && $linea != "" ){
					
					if ( Utils::startsWith($linea, "Caption") ){

						$auxArray = explode(",", $linea);
						$Caption = $auxArray[1];

						$arrayCaption[$i] = $Caption;
						$i++;

					} else if ( Utils::startsWith($linea, "Manufacturer") ){

						$auxArray = explode(",", $linea);
						$Manufacturer = $auxArray[1];

						$arrayManufacturer[$j] = $Manufacturer;
						$j++;
					}
				}
			}

			$result .= "<br/>Resumen de Sound.csv: "
				. "<br/>Cantidad de dispositivos de Sonidos de tiene este Equipo: $i";

			$result .= "<br/>" . Equipos::insertarSound($equipoInfoId, $arrayCaption, $arrayManufacturer, $legacyNumber);

			return $result;

		} catch ( \Exception $e ) {
			return "<br/><b>NO se pudo procesar el Archivo 5: Sound.csv</b>. Causa: " . $e -> getMessage();
		}
	}
	

	/**
	 * Leyendo archivo .CSV: Video
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Video']['tmp_name']
	 * @param $file_name 		$_FILES['Video']['name']
	 * @param $file_size 		$_FILES["Video"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvVideo( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber ){
		try {
			$result = "<br><b>Archivo 6: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;

			$a="";
			$AdapterCompatibility="";$AdapterRAM="";$Name="";$VideoProcessor="";
			$arrayAdapterCompatibility[0]="";$arrayAdapterRAM[0]="";$arrayName[0]="";$arrayVideoProcessor[0]="";

			$i=0;$j=0;$k=0;$l=0;
			foreach ( $array as $linea ){
				if ( $linea != NULL && $linea != "" ){
					
					if ( Utils::startsWith($linea, "AdapterCompatibility") ){

						$auxArray = explode(",", $linea);
						$AdapterCompatibility = $auxArray[1];

						$arrayAdapterCompatibility[$i] = $AdapterCompatibility;
						$i++;

					} else if ( Utils::startsWith($linea, "AdapterRAM") ){

						$auxArray = explode(",", $linea);
						$AdapterRAM = $auxArray[1];

						$arrayAdapterRAM[$j] = $AdapterRAM;
						$j++;

					} else if ( Utils::startsWith($linea, "Name") ){

						$auxArray = explode(",", $linea);
						$Name = $auxArray[1];

						$arrayName[$k] = $Name;
						$k++;

					} else if ( Utils::startsWith($linea, "VideoProcessor") ){

						$auxArray = explode(",", $linea);
						$VideoProcessor = $auxArray[1];

						$arrayVideoProcessor[$l] = $VideoProcessor;
						$l++;

					}
				}
			}

			$result .= "<br/>Resumen de Video.csv: "
				. "<br/>Cantidad de dispositivos de Video que tiene este Equipo: $i";

			$result .= "<br/>" . Equipos::insertarVideo( $equipoInfoId, $arrayAdapterCompatibility, 
					$arrayAdapterRAM, $arrayName, $arrayVideoProcessor, $legacyNumber);

			return $result;

		} catch ( \Exception $e ) {
			return "<br/><b>NO se pudo procesar el Archivo 6: Video.csv</b>. Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Leyendo archivo .CSV: OS
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['OS']['tmp_name']
	 * @param $file_name 		$_FILES['OS']['name']
	 * @param $file_size 		$_FILES["OS"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 * @param $equipoId 		ID A_I del Equipo creado
	 *
	 * @param $tipoDeActualizacionDeInfoBasica  {"new", "concat"}
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvOS( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $equipoId,
			$legacyNumber, $tipoDeActualizacionDeInfoBasica ){
		try {
			$result = "<br><b>Archivo 7: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";
			
			$i=0;
			$a="";
			$Caption="";$CSName="";$Workgroup="";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;

			foreach ( $array as $linea ){
				$i++;
				if ( $linea != NULL && $linea != "" ){

					if ( Utils::startsWith($linea, "Caption") ){
						
						$auxArray = explode(",", $linea);
						$Caption = $auxArray[1];

					} else if ( Utils::startsWith($linea, "CSName") ){
						
						$auxArray = explode(",", $linea);
						$CSName = $auxArray[1];

					} else if ( Utils::startsWith($linea, "Workgroup")){
						
						$auxArray = explode(",", $linea);
						$Workgroup = $auxArray[1];
					}
				}
				if ( $i == 4 ){
					break 1;/* solo las primeras 3 lineas se van a leer; la otra DATA vendrá luego en Software.csv, cuando felipe andres lo acomode */
				}
			}

			$result .= "<br/>Resumen de OS.csv: "
				. "<br/>Sistema: $Caption"
				. "<br/>CSName: $CSName"
				. "<br/>Grupo de Trabajo: $Workgroup";
			
			$result .= "<br/>" . Equipos::insertarOS($equipoInfoId, $Caption, $CSName, $Workgroup, $legacyNumber);

			/*
			 * Actualizar la info basica del Equipo
			 */
			$texto = ", " . $Caption;
			Equipos::actualizarInfoBasica($equipoId, $texto, $tipoDeActualizacionDeInfoBasica);

			return $result;

		} catch (\Exception $e) {
			return "<br/><b>NO se pudo procesar el Archivo 7: OS.csv</b>. Causa: " . $e -> getMessage();
		}
	}

	
	/**
	 * Leyendo archivo .CSV: Hard drives
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Hard drives']['tmp_name']
	 * @param $file_name 		$_FILES['Hard drives']['name']
	 * @param $file_size 		$_FILES["Hard drives"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvHardDrives( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber){
		try {
			$result = "<br><b>Archivo 8: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;
			$a="";
			
			/*
			 * En caso de Particion
			 */
			$Capacity="";$DriveLetter="";$DriveType="";$FileSystem="";$FreeSpace="";
			$arrayCapacity[0]=""; $arrayDriveLetter[0]=""; $arrayDriveType[0]=""; $arrayFileSystem[0]=""; $arrayFreeSpace[0]="";
			$arrayCapacity2[0]="";$arrayDriveLetter2[0]="";$arrayDriveType2[0]="";$arrayFileSystem2[0]="";$arrayFreeSpace2[0]="";
			
			/* En caso de Leer una particion que SÍ contenga letra (ejemplo C:) se agregará a este arreglo;
			 * las demás no se usarán. Es decir, los indices que NO esten acá no se tomaran en cuenta
			 */
			$arrayIndicesAUsarParticion[0]=0;
			$contIndices=0;

			/*
			 * En caso de Disco Fisico
			 */
			$InterfaceType="";$Model="";$SerialNumber="";$Size="";
			$arrayInterfaceType[0]="";$arrayModel[0]="";$arraySerialNumber[0]="";$arraySize[0]="";
			
			/*
			 * Contadores
			 */
			$contParticiones=-1;
			$contDiscos=-1;
			
			foreach ( $array as $linea ){
				if ( $linea != NULL && $linea != "" ){
					
					/*
					 *     leyendo si es Particion
					 */
					if ( Utils::startsWith($linea, "Capacity") ){

						/* una nueva particion */
						$contParticiones++;

						$auxArray = explode(",", $linea);
						$Capacity = $auxArray[1];

						$arrayCapacity[$contParticiones] = $Capacity;

					} else if ( Utils::startsWith($linea, "DriveLetter") ){

						$auxArray = explode(",", $linea);
						$DriveLetter = $auxArray[1];

						$arrayDriveLetter[$contParticiones] = $DriveLetter;

						$DriveLetter = trim($DriveLetter);

						if ( $DriveLetter != NULL && $DriveLetter != "" ){
							/*
							 * añadiendo indice al Vector de los segmentos a tomar en cuenta
							 */	
							$arrayIndicesAUsarParticion[$contIndices] = $contParticiones;
							$contIndices++;
						}

					} else if ( Utils::startsWith($linea, "DriveType") ){

						$auxArray = explode(",", $linea);
						$DriveType = $auxArray[1];

						$arrayDriveType[$contParticiones] = $DriveType;

					} else if ( Utils::startsWith($linea, "FileSystem") ){

						$auxArray = explode(",", $linea);
						$FileSystem = $auxArray[1];


						$arrayFileSystem[$contParticiones] = $FileSystem;

					} else if ( Utils::startsWith($linea, "FreeSpace") ){

						$auxArray = explode(",", $linea);
						$FreeSpace = $auxArray[1];

						$arrayFreeSpace[$contParticiones] = $FreeSpace;
					}

					/*
					 *     leyendo si es Disco Fisico
					 */
					else if ( Utils::startsWith($linea, "InterfaceType") ){

						/* una nueva particion */
						$contDiscos++;

						$auxArray = explode(",", $linea);
						$InterfaceType = $auxArray[1];

						$arrayInterfaceType[$contDiscos] = $InterfaceType;

					} else if ( Utils::startsWith($linea, "Model") ){
						
						$auxArray = explode(",", $linea);
						$Model = $auxArray[1];

						$arrayModel[$contDiscos] = $Model;

					} else if ( Utils::startsWith($linea, "SerialNumber") ){
						
						$auxArray = explode(",", $linea);
						$SerialNumber = $auxArray[1];

						$SerialNumber = trim($SerialNumber);
						
						$arraySerialNumber[$contDiscos] = $SerialNumber;

					} else if ( Utils::startsWith($linea, "Size") ){
						
						$auxArray = explode(",", $linea);
						$Size = $auxArray[1];

						$arraySize[$contDiscos] = $Size;
					}

				}
			}

			$contDiscos++;

			$result .= "<br/>Resumen de Hard drives.csv: "
				. "<br/>Cantidad de Particiones que tiene este Equipo: " . ( $contParticiones + 1 )
				. "<br/>Cantidad de Discos Físicos: " . $contDiscos;

			/*
			 * Depurar las Particiones que NO tienen letras
			 */
			$aux="";
			for ( $i = 0; $i < $contIndices; $i++ ){

				$indice = $arrayIndicesAUsarParticion[$i];

				$arrayCapacity2[$i] 	= $arrayCapacity[$indice];
				$arrayDriveType2[$i] 	= $arrayDriveType[$indice];    
				$arrayFileSystem2[$i]   = $arrayFileSystem[$indice];
				$arrayFreeSpace2[$i] 	= $arrayFreeSpace[$indice];

				$arrayDriveLetter2[$i]  = $arrayDriveLetter[$indice];
				$aux .= " " . $arrayDriveLetter2[$i] . " - ";
			}

			$result .= "<br/>Letras de Particiones halladas: " . $aux;

			$result .= "<br/>" . Equipos::insertarHardDrives($equipoInfoId,
					$contIndices, 
					$arrayCapacity2, $arrayDriveLetter2, $arrayDriveType2, $arrayFileSystem2, $arrayFreeSpace2,
					$contDiscos,
					$arrayInterfaceType, $arrayModel, $arraySerialNumber, $arraySize,
					$legacyNumber
				);

			return $result;

		} catch ( \Exception $e ) {
			return "<br/><b>NO se pudo procesar el Archivo 8: Hard drives.csv</b>. Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Leyendo archivo .CSV: SMART
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['SMART']['tmp_name']
	 * @param $file_name 		$_FILES['SMART']['name']
	 * @param $file_size 		$_FILES["SMART"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvSMART( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber ){
		try {
			$result = "<br><b>Archivo 9: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;
			$a="";

			/* Valores obligatorios */
			$Serial="";$Model="";$Power_on_hours="";

			/* Valores opcionales */
			$HDDtemperature="";$Reallocated="";

			$arraySMART[0]["Serial"]="";
			
			$contadorPowerOn=0;

			$contadorSMART=-1;
			foreach ( $array as $linea ){
				if ( $linea != NULL && $linea != "" ){
					
					if ( Utils::startsWith($linea, "Serial") ){
						/*
						 * 1ra. linea 
						 * Nueva entrada de Red
						 */
						$contadorSMART++;

						/* Reiniciar contador de IP's */
						$contadorPowerOn=0;

						$auxArray = explode(",", $linea);
						$Serial = $auxArray[1];

						/*
						 * Poniendo todos los valores por defecto
						 */
						$arraySMART[$contadorSMART]["Serial"] 					= $Serial;
						$arraySMART[$contadorSMART]["Model"] 					= "";
						$arraySMART[$contadorSMART]["Power_on_hours_1"] 		= 0;
						$arraySMART[$contadorSMART]["Power_on_hours_2"] 		= 0;
						$arraySMART[$contadorSMART]["HDD_temperature"] 			= 0;
						$arraySMART[$contadorSMART]["Reallocated_sector_count"] = 0;


					} else if ( Utils::startsWith($linea, "Model") ){

						$auxArray = explode(",", $linea);
						$Model = $auxArray[1];

						$arraySMART[$contadorSMART]["Model"] = $Model;

					} else if ( Utils::startsWith($linea, "HDD temperature") ){

						$auxArray = explode(",", $linea);
						$HDDtemperature = $auxArray[1];

						$arraySMART[$contadorSMART]["HDD_temperature"] = $HDDtemperature;

					} else if ( Utils::startsWith($linea, "Reallocated sector count") ){

						$auxArray = explode(",", $linea);
						$Reallocated = $auxArray[1];

						$arraySMART[$contadorSMART]["Reallocated_sector_count"] = $Reallocated;

					} else if ( Utils::startsWith($linea, "Power-on hours") ){

						$auxArray = explode(",", $linea);
						$Power_on_hours = $auxArray[1];

						if ( $contadorPowerOn == 0 ){
							$arraySMART[$contadorSMART]["Power_on_hours_1"] = $Power_on_hours;

						} else if ( $contadorPowerOn == 1 ){
							$arraySMART[$contadorSMART]["Power_on_hours_2"] = $Power_on_hours;
						}

						/* Puede venir 2 contadores de horas encendidas. Guardar solo 2 */
						$contadorPowerOn++;
					}
				}
			}

			$result .= "<br/>Resumen de SMART.csv: "
				. "<br/>Cantidad de dispositivos leídos: " . ( $contadorSMART + 1 );

			$result .= "<br/>" . Equipos::insertarSMART($equipoInfoId, $contadorSMART, $arraySMART, $legacyNumber);

			return $result;

		} catch ( \Exception $e ) {
			return "<br/><b>NO se pudo procesar el Archivo 9: SMART.csv</b>. Causa: " . $e -> getMessage();
		}
	}

	
	/**
	 * Leyendo archivo .CSV: Networking
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Networking']['tmp_name']
	 * @param $file_name 		$_FILES['Networking']['name']
	 * @param $file_size 		$_FILES["Networking"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvNetworking( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber ){
		try {
			$result = "<br><b>Archivo 10: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;
			$a="";

			$Adapter="";$AdapterType="";$MAC="";$IP="";$DCHPEnabled="";
			$arrayRED[0]["Adapter"]="";
			
			$contadorIP=0;

			$contadorRedes=-1;
			foreach ( $array as $linea ){
				if ( $linea != NULL && $linea != "" ){
					
					if ( Utils::startsWith($linea, "AdapterType") ){

						$auxArray = explode(",", $linea);
						$AdapterType = $auxArray[1];

						$arrayRED[$contadorRedes]["AdapterType"] = $AdapterType;


					} else if ( Utils::startsWith($linea, "Adapter") ){
						/*
						 * 1ra. linea 
						 * Nueva entrada de Red
						 */
						$contadorRedes++;

						/* Reiniciar contador de IP's */
						$contadorIP=0;

						$auxArray = explode(",", $linea);
						$Adapter = $auxArray[1];

						$arrayRED[$contadorRedes]["Adapter"] = $Adapter;

					} else if ( Utils::startsWith($linea, "MAC") ){

						$auxArray = explode(",", $linea);
						$MAC = $auxArray[1];

						$arrayRED[$contadorRedes]["MAC"] = $MAC;

					} else if ( Utils::startsWith($linea, "DCHPEnabled") ){

						$auxArray = explode(",", $linea);
						$DCHPEnabled = $auxArray[1];

						$arrayRED[$contadorRedes]["DCHPEnabled"] = $DCHPEnabled;

					} else if ( Utils::startsWith($linea, "IP") ){

						$auxArray = explode(",", $linea);
						$IP = $auxArray[1];

						if ( $contadorIP == 0 ){
							$arrayRED[$contadorRedes]["IP_1"] = $IP;
							$arrayRED[$contadorRedes]["IP_2"] = NULL;

						} else if ( $contadorIP == 1 ){
							$arrayRED[$contadorRedes]["IP_2"] = $IP;
						}

						/* Direccion IP, puede venir 2 IP's en una red. Guardar solo 2 */
						$contadorIP++;
					}
				}
			}

			$result .= "<br/>Resumen de Networking.csv: "
				. "<br/>Cantidad de dispositivos de RED: " . ( $contadorRedes + 1 );

			$result .= "<br/>" . Equipos::insertarNetworking($equipoInfoId, $contadorRedes, $arrayRED, $legacyNumber);

			return $result;

		} catch ( \Exception $e ) {
			return "<br/><b>NO se pudo procesar el Archivo 10: Networking.csv</b>. Causa: " . $e -> getMessage();
		}
	}


	/**
	 * Leyendo archivo .CSV: Software
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Software']['tmp_name']
	 * @param $file_name 		$_FILES['Software']['name']
	 * @param $file_size 		$_FILES["Software"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return String resultado del procesamiento
	 */
	public static function csvSoftware( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $legacyNumber ){
		try {
			$result = "<br><b>Archivo 11: " . $file_name . "</b>";

			$result .= "<br>Tamaño: " . $file_size . " bytes";

			$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

			$result .= "<br><i>Procesando...</i> ";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;
			$a="";

			$Caption="";$InstallDate="";$Version="";$Cap="";
			$arraySoft[0]["Caption"]="";
			
			$contadorProgramas=-1;

			/* Evitar el InstallDate2 que viene vacio */
			$installed = false;

			foreach ( $array as $linea ){

				if ( $linea != NULL && $linea != "" ){
					
					if ( Utils::startsWith($linea, "Caption") ){
						/*
						 * 1ra. linea 
						 * Nueva entrada de Red
						 */
						$contadorProgramas++;

						$installed = false;

						$auxArray = explode(",", $linea);
						$Caption = $auxArray[1];

						/* Hay problemas al insertar texto como "ò", "á", "û", etc... */
						$Cap = Utils::transliterateString($Caption);

						$arraySoft[$contadorProgramas]["Caption"] = $Cap;

					} else if ( Utils::startsWith($linea, "InstallDate") && $installed == false ){

						$auxArray = explode(",", $linea);
						$InstallDate = $auxArray[1];

						$arraySoft[$contadorProgramas]["InstallDate"] = $InstallDate;

						$installed = true;

					} else if ( Utils::startsWith($linea, "Version") ){

						$auxArray = explode(",", $linea);
						$Version = $auxArray[1];

						$arraySoft[$contadorProgramas]["Version"] = $Version;
					}
				}
			}

			$contadorProgramas++;

			$result .= "<br/>Resumen de Software.csv: "
				. "<br/>Cantidad de programas instalados: " . $contadorProgramas;

			$result .= "<br/>" . Equipos::insertarSoftware($equipoInfoId, $contadorProgramas, $arraySoft, $legacyNumber);

			return $result;

		} catch ( \Exception $e ) {
			return "<br/><b>NO se pudo procesar el Archivo 11: Software.csv</b>. Causa: " . $e -> getMessage();
		}
	}

	
	/**
	 * Devolver en un objeto TODA la info de las Tablas Inventario
	 * @param  $equipoInfoId   		equipoInfoId que está en la tabla Equipos
	 * @return array de resultados	
	 */
	public static function equipoInfoInventario( $equipoInfoId ){

		$errorMessage = "";

		try {
			$response["os"] = Equipos::inventarioOS( $equipoInfoId );

		} catch (Exception $e) {
			$response["os"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}

		try {
			$response["cpu"] = Equipos::inventarioCPU( $equipoInfoId );

		} catch (Exception $e) {
			$response["cpu"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}
		
		try {
			$response["motherboard"] = Equipos::inventarioMotherboard( $equipoInfoId );

		} catch (Exception $e) {
			$response["motherboard"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}

		try {
			$response["ram"] = Equipos::inventarioRAM( $equipoInfoId );

		} catch (Exception $e) {
			$response["ram"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}

		try {
			$response["users"] = Equipos::inventarioLocalUsers( $equipoInfoId );

		} catch (Exception $e) {
			$response["users"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}
		
		try {
			$response["hardDrives"] = Equipos::inventarioHardDrives( $equipoInfoId );

		} catch (Exception $e) {
			$response["hardDrives"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}
		
		try {
			$response["sound"] = Equipos::inventarioSound( $equipoInfoId );

		} catch (Exception $e) {
			$response["sound"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}
		
		try {
			$response["video"] = Equipos::inventarioVideo( $equipoInfoId );

		} catch (Exception $e) {
			$response["video"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}
		
		try {
			$response["networking"] = Equipos::inventarioNetworking( $equipoInfoId );

		} catch (Exception $e) {
			$response["networking"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}
		
		try {
			$response["smart"] = Equipos::inventarioSmart( $equipoInfoId );

		} catch (Exception $e) {
			$response["smart"] = NULL;
			$errorMessage .= " | " . $e -> getMessage();
		}

		$response["errorMessage"] = $errorMessage;

		return $response;
	}


	/**
	 ************************************************************************************************************
	 ************************************************************************************************************
	 * Leyendo archivo .CSV: CPU
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['CPU']['tmp_name']
	 * @param $file_name 		$_FILES['CPU']['name']
	 * @param $file_size 		$_FILES["CPU"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {cpuId, resumen, count, legacyNumber, oldCpuId}
	 */
	public static function csvActualizarCPU($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){

		/*
		 * 1.- Al valor que ya existe: 
		 * - update isLegacy = true
		 * - obtener su LegacyNumber
		 */
		$result = "<br><b>Archivo: " . $file_name . "</b>";

		$result .= "<br>Tamaño: " . $file_size . " bytes";

		$result .= "<br>Almacenamiento temporal: " . $file_tmp_name;

		$result .= "<br><i>Procesando...</i> ";

		$object = Equipos::cpuGetLegacyNumberAndSetTrue($equipoInfoId);
		

		/*
		 * 2.- INSERTAR un nuevo valor en ICPU con LegacyNumber++
		 * - obteniendo primero el MAX_ID
		 */
		$LN = $object->legacyNumber;
		$LN++;
		$array = InventarioScripts::actualizarInventarioCPU($equipoId, $contenidoArchivo, $LN);

		$result .= "<br>" . $array['resumen'];

		/*
		 * 3.- UPDATE EquipoInfo con el nuevo id
		 */
		$newMAX_ID = $array['cpuId'];

		$count = Equipos::updateEquipoInfo2campos($equipoInfoId, $newMAX_ID, "CPU");

		/*
		 * devolver objeto con resumen de todo
		 */
		$out['cpuId']   	 = $newMAX_ID;
		$out['resumen'] 	 = $result;
		$out['count']        = $count;
		$out['legacyNumber'] = ($LN - 1);
		$out['oldCpuId']     = $object->cpuId;

		return $out;
	}
	

	/**
	 * insertando NUEVA data de CPU
	 * @param $legacyNumber    el numero de la vez que esta siendo inventariado este equipo
	 * @return Array[3]: 0.- el ID nuevo | 1.- numero de filas insertadas | 2.- info resultado para el Tecnico
	 */
	public static function actualizarInventarioCPU($equipoId, $contenidoArchivo, $legacyNumber){
		try {
			$cpu="";
			$i=0;

			$a="";
			$AddressWidth="";$CurrentClockSpeed="";$L2CacheSize="";
			$L3CacheSize="";$Name="";$NumberOfCores="";

			/*
			 * Dividiendo el Contenido por lineas (separando por ENTER)
			 */
			$array = explode("\n", $contenidoArchivo);
			
			$auxArray = NULL;

			foreach ( $array as $linea ){
				
				$i++;
				if ( $linea != NULL && $linea != "" ){

					if ( Utils::startsWith($linea, "AddressWidth") ){
						
						$auxArray = explode(",", $linea);
						$AddressWidth = $auxArray[1];

					} else if ( Utils::startsWith($linea, "CurrentClockSpeed") ){
						
						$auxArray = explode(",", $linea);
						$CurrentClockSpeed = $auxArray[1];

					} else if ( Utils::startsWith($linea, "L2CacheSize") ){
						
						$auxArray = explode(",", $linea);
						$L2CacheSize = $auxArray[1];

					} else if ( Utils::startsWith($linea, "L3CacheSize") ){
						
						$auxArray = explode(",", $linea);
						$L3CacheSize = $auxArray[1];

					} else if ( Utils::startsWith($linea, "Name") ){
						
						$auxArray = explode(",", $linea);
						$Name = $auxArray[1];

					} else if ( Utils::startsWith($linea, "NumberOfCores") ){
						
						$auxArray = explode(",", $linea);
						$NumberOfCores = $auxArray[1];
					}
				}
			}

			$cpu .= "<br/>Resumen de CPU.csv: "
				. "<br/>Nombre: $Name"
				. "<br/>Número de Núcleos: $NumberOfCores"
				. "<br/>Máquina de $AddressWidth bits.";

			/*
			 * Insertar esta data en tabla ICPU y obtener su id A_I
			 */
			$maxID = Equipos::getMaxID("ICPU");
			$maxID++;
			$count = Equipos::insertarCPU($maxID, $AddressWidth, $CurrentClockSpeed, $L2CacheSize, $L3CacheSize, $Name, $NumberOfCores, $legacyNumber);

			$out['cpuId']   = $maxID;
			$out['count']   = $count;
			$out['resumen'] = $cpu;

			/*
			 * Sobreescribir la info basica del Equipo
			 */
			$texto = $Name;
			if ( $NumberOfCores == 1 ){
				$texto .= ", 1 Núcleo";
			} else {
				$texto .= ", $NumberOfCores Núcleos";
			}

			Equipos::actualizarInfoBasica($equipoId, $texto, "new");

			return $out;

		} catch (\Exception $e) {
			$out['cpuId']   = -1;
			$out['resumen'] =  $e -> getMessage();
			return $out;
		}
	}

	
	/**
	 * Leyendo archivo .CSV: Motherboard
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Motherboard']['tmp_name']
	 * @param $file_name 		$_FILES['Motherboard']['name']
	 * @param $file_size 		$_FILES["Motherboard"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {mbId, resumen, count, legacyNumber, oldMbId}
	 */
	public static function csvActualizarMotherboard($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){

		/*
		 * 1.- Al valor que ya existe: 
		 * - update isLegacy = true
		 * - obtener su LegacyNumber
		 */
		$object = Equipos::motherboardGetLegacyNumberAndSetTrue($equipoInfoId);
		

		/*
		 * 2.- INSERTAR un nuevo valor en ICPU con LegacyNumber++
		 * - obteniendo primero el MAX_ID
		 */
		$LN = $object->legacyNumber;
		$LN++;
		$array = InventarioScripts::csvMotherboard($equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN);

		$result = "<br>" . $array['info'] . " " . $array['resumen'];
		

		/*
		 * 3.- UPDATE EquipoInfo con el nuevo id
		 */
		$newMAX_ID = $array['mbId'];

		$count = Equipos::updateEquipoInfo2campos($equipoInfoId, $newMAX_ID, "Motherboard");

		/*
		 * devolver objeto con resumen de todo
		 */
		$out['mbId']   		 = $newMAX_ID;
		$out['resumen'] 	 = $result;
		$out['count']        = $count;
		$out['legacyNumber'] = ($LN - 1);
		$out['oldMbId']      = $object->motherboardId;

		return $out;
	}


	/**
	 * Leyendo archivo .CSV: RAM
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['RAM']['tmp_name']
	 * @param $file_name 		$_FILES['RAM']['name']
	 * @param $file_size 		$_FILES["RAM"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {oldRamIds, resumen, legacyNumber}
	 */
	public static function csvActualizarRAM($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$arrayIds = Equipos::ramGetLegacyNumberAndSetTrue($equipoInfoId);

		if ( $arrayIds != null ){

			$LN = 0; $stringIds = "";

			foreach ( $arrayIds as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			/*
			 * 2.- INSERTAR los que vienen en el archivo para Actualizar
			 * - con el LegacyNumber actualizado
			 */
			$LN++;
			$stringResult = InventarioScripts::csvRAM( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN );

			/*
			 * 3.- Devolver los ID's de las antiguas entradas en forma csv. Ej.: 1,23,456
			 * - para guardarlo en el Historial
			 * - devolver el viejo LegacyNumber
			 */
			$out["resumen"] 	 = $stringResult;
			$out["legacyNumber"] = ($LN - 1);
			$out["oldRamIds"] 	 = $stringIds;

			return $out;
		}
	}


	/**
	 * Leyendo archivo .CSV: Hard drives
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Hard_drives']['tmp_name']
	 * @param $file_name 		$_FILES['Hard_drives']['name']
	 * @param $file_size 		$_FILES["Hard_drives"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {oldHDIds, resumen, legacyNumber}
	 */
	public static function csvActualizarHardDrives($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$arrayIds = Equipos::hardDrivesGetLegacyNumberAndSetTrue($equipoInfoId);

		if ( $arrayIds != null ){

			$LN = 0; $stringIds = "";

			foreach ( $arrayIds as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			/*
			 * 2.- INSERTAR los que vienen en el archivo para Actualizar
			 * - con el LegacyNumber actualizado
			 */
			$LN++;
			$stringResult = InventarioScripts::csvHardDrives( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN );

			/*
			 * 3.- Devolver los ID's de las antiguas entradas en forma csv. Ej.: 1,23,456
			 * - para guardarlo en el Historial
			 * - devolver el viejo LegacyNumber
			 */
			$out["resumen"] 	 = $stringResult;
			$out["legacyNumber"] = ($LN - 1);
			$out["oldHDIds"] 	 = $stringIds;

			return $out;
		}
	}


	/**
	 * Leyendo archivo .CSV: SMART
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['SMART']['tmp_name']
	 * @param $file_name 		$_FILES['SMART']['name']
	 * @param $file_size 		$_FILES["SMART"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {oldSmartIds, resumen, legacyNumber}
	 */
	public static function csvActualizarSMART($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$arrayIds = Equipos::smartGetLegacyNumberAndSetTrue($equipoInfoId);

		if ( $arrayIds != null ){

			$LN = 0; $stringIds = "";

			foreach ( $arrayIds as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			/*
			 * 2.- INSERTAR los que vienen en el archivo para Actualizar
			 * - con el LegacyNumber actualizado
			 */
			$LN++;
			$stringResult = InventarioScripts::csvSMART( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN );

			/*
			 * 3.- Devolver los ID's de las antiguas entradas en forma csv. Ej.: 1,23,456
			 * - para guardarlo en el Historial
			 * - devolver el viejo LegacyNumber
			 */
			$out["resumen"] 	 = $stringResult;
			$out["legacyNumber"] = ($LN - 1);
			$out["oldSmartIds"]  = $stringIds;

			return $out;
		}
	}

	/**
	 * Leyendo archivo .CSV: LocalUsers
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['LocalUsers']['tmp_name']
	 * @param $file_name 		$_FILES['LocalUsers']['name']
	 * @param $file_size 		$_FILES["LocalUsers"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {oldLocalUsersIds, resumen, legacyNumber}
	 */
	public static function csvActualizarLocalUsers($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$arrayIds = Equipos::localUsersGetLegacyNumberAndSetTrue($equipoInfoId);

		if ( $arrayIds != null ){

			$LN = 0; $stringIds = "";

			foreach ( $arrayIds as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			/*
			 * 2.- INSERTAR los que vienen en el archivo para Actualizar
			 * - con el LegacyNumber actualizado
			 */
			$LN++;
			$stringResult = InventarioScripts::csvLocalUsers( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN );

			/*
			 * 3.- Devolver los ID's de las antiguas entradas en forma csv. Ej.: 1,23,456
			 * - para guardarlo en el Historial
			 * - devolver el viejo LegacyNumber
			 */
			$out["resumen"] 	 	 = $stringResult;
			$out["legacyNumber"]	 = ($LN - 1);
			$out["oldLocalUsersIds"] = $stringIds;

			return $out;
		}
	}

	/**
	 * Leyendo archivo .CSV: Sound
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Sound']['tmp_name']
	 * @param $file_name 		$_FILES['Sound']['name']
	 * @param $file_size 		$_FILES["Sound"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {oldSoundIds, resumen, legacyNumber}
	 */
	public static function csvActualizarSound($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$arrayIds = Equipos::soundGetLegacyNumberAndSetTrue($equipoInfoId);

		if ( $arrayIds != null ){

			$LN = 0; $stringIds = "";

			foreach ( $arrayIds as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			/*
			 * 2.- INSERTAR los que vienen en el archivo para Actualizar
			 * - con el LegacyNumber actualizado
			 */
			$LN++;
			$stringResult = InventarioScripts::csvSound( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN );

			/*
			 * 3.- Devolver los ID's de las antiguas entradas en forma csv. Ej.: 1,23,456
			 * - para guardarlo en el Historial
			 * - devolver el viejo LegacyNumber
			 */
			$out["resumen"] 	 	= $stringResult;
			$out["legacyNumber"] 	= ($LN - 1);
			$out["oldSoundIds"]		= $stringIds;

			return $out;
		}
	}

	/**
	 * Leyendo archivo .CSV: Networking
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Networking']['tmp_name']
	 * @param $file_name 		$_FILES['Networking']['name']
	 * @param $file_size 		$_FILES["Networking"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {oldNetworkingIds, resumen, legacyNumber}
	 */
	public static function csvActualizarNetworking($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$arrayIds = Equipos::networkingGetLegacyNumberAndSetTrue($equipoInfoId);

		if ( $arrayIds != null ){

			$LN = 0; $stringIds = "";

			foreach ( $arrayIds as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			/*
			 * 2.- INSERTAR los que vienen en el archivo para Actualizar
			 * - con el LegacyNumber actualizado
			 */
			$LN++;
			$stringResult = InventarioScripts::csvNetworking( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN );

			/*
			 * 3.- Devolver los ID's de las antiguas entradas en forma csv. Ej.: 1,23,456
			 * - para guardarlo en el Historial
			 * - devolver el viejo LegacyNumber
			 */
			$out["resumen"] 	 	= $stringResult;
			$out["legacyNumber"] 	= ($LN - 1);
			$out["oldNetworkingIds"]= $stringIds;

			return $out;
		}
	}

	/**
	 * Leyendo archivo .CSV: Video
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Video']['tmp_name']
	 * @param $file_name 		$_FILES['Video']['name']
	 * @param $file_size 		$_FILES["Video"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {oldVideoIds, resumen, legacyNumber}
	 */
	public static function csvActualizarVideo($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$arrayIds = Equipos::videoGetLegacyNumberAndSetTrue($equipoInfoId);

		if ( $arrayIds != null ){

			$LN = 0; $stringIds = "";

			foreach ( $arrayIds as $row ){
				/* legacy */
				$LN = Utils::tomarElMayor( $LN, $row[0] );

				/* ID's en forma CSV */
				$stringIds .= $row[1] . ",";
			}

			/* substring el ultimo caracter, eliminar la ultima coma */
			$stringIds = rtrim($stringIds,",");

			/*
			 * 2.- INSERTAR los que vienen en el archivo para Actualizar
			 * - con el LegacyNumber actualizado
			 */
			$LN++;
			$stringResult = InventarioScripts::csvVideo( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN );

			/*
			 * 3.- Devolver los ID's de las antiguas entradas en forma csv. Ej.: 1,23,456
			 * - para guardarlo en el Historial
			 * - devolver el viejo LegacyNumber
			 */
			$out["resumen"] 	 	= $stringResult;
			$out["legacyNumber"] 	= ($LN - 1);
			$out["oldVideoIds"]		= $stringIds;

			return $out;
		}
	}


	/**
	 * Leyendo archivo .CSV: OS
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['OS']['tmp_name']
	 * @param $file_name 		$_FILES['OS']['name']
	 * @param $file_size 		$_FILES["OS"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @param tipoDeActualizacionDeInfoBasica {"new","concat"}
	 *
	 * @return Array {oldOSId, resumen, legacyNumber}
	 */
	public static function csvActualizarOS($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo,
			$tipoDeActualizacionDeInfoBasica){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$object = Equipos::osGetLegacyNumberAndSetTrue($equipoInfoId);

		/*
		 * 2.- INSERTAR los que vienen en el archivo para Actualizar
		 * - con el LegacyNumber actualizado
		 */
		$LN = $object->legacyNumber;
		$LN++;
		$stringResult = InventarioScripts::csvOS( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo,
				$equipoId, $LN, $tipoDeActualizacionDeInfoBasica );

		/*
		 * 3.- Devolver los ID de la antigua entrada para guardarlo en el Historial
		 * - devolver el viejo LegacyNumber
		 */
		$out["resumen"] 	= $stringResult;
		$out["legacyNumber"]= ($LN - 1);
		$out["oldOSId"]		= $object->osId;

		return $out;
	}

	/**
	 * Leyendo archivo .CSV: Software
	 *
	 * @param $equipoInfoId		Enlace a tabla EquipoInfo
	 * @param $file_tmp_name    $_FILES['Software']['tmp_name']
	 * @param $file_name 		$_FILES['Software']['name']
	 * @param $file_size 		$_FILES["Software"]["size"]
	 * @param $contenidoArchivo file_get_contents()
	 *
	 * @return Array {oldSoftwareId, resumen, legacyNumber}
	 */
	public static function csvActualizarSoftware($equipoId, $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo){
		/*
		 * 1.- A todos los que existen:
		 * - update isLegacy = true
		 * - obtener sus LegacyNumber's
		 */
		$object = Equipos::softwareGetLegacyNumberAndSetTrue($equipoInfoId);

		/*
		 * 2.- INSERTAR los que vienen en el archivo para Actualizar
		 * - con el LegacyNumber actualizado
		 */
		$LN = $object->legacyNumber;
		$LN++;
		$stringResult = InventarioScripts::csvSoftware( $equipoInfoId, $file_tmp_name, $file_name, $file_size, $contenidoArchivo, $LN);

		/*
		 * 3.- Devolver los ID de la antigua entrada para guardarlo en el Historial
		 * - devolver el viejo LegacyNumber
		 */
		$out["resumen"] 		= $stringResult;
		$out["legacyNumber"]	= ($LN - 1);
		$out["oldSoftwareId"]	= $object->id;

		return $out;
	}

}