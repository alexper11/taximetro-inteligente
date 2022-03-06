# taximetro-inteligente
Sistema de rastreo que realiza el calculo de desplazamiento y tiempo. Los datos son usados por un sistema remoto y almacenados en una base de datos.

El sistema permite tener un dispositivo que realiza el cálculo del valor a pagar por un servicio de transporte teniendo en cuenta variables como el desplazamiento realizado y 
tiempos de espera. Los datos del servicio (ubicación de recogida, ubicación de destino, costo del servicio, kilómetros recorridos, ubicaciones cada cierto periodo de tiempo) 
se envían a un sistema remoto. El vehiculo con el servicio de taximetro inteligente tiene un dispositivo microcontrolado que sensa los datos de ubicación (Placa Arduino + Modulo GPS)
y los envía a una base de datos y un sistema remoto (además de presentar cierta información a través de LEDs) y al dispositivo (smartphone o tablet) donde se visualizará el mapa 
por donde transita el vehículo, información del conductor y del vehículo, el punto de recogida, el trayecto recorrido, la cantidad de kilometros recorridos,
la cantidad de tiempo de servicio, el valor del servicio que se lleva hasta cierto momento y un código QR que el usuario podrá leer para acceder a la información en su celular. 
Existen varios tipos de usuario: usuario conductor, usuario administrador y usuario pasajero, cada uno con diferentes interfaces y funciones a disposición con tal de ofrecer
adecuados servicios de transporte. Los datos son creados, almacedanos, analizados y visualizados a traves del flujo de trabajo del sistema que comprende una parte Hardware y una
parte Software.
