import 'dart:math';
import 'package:intl/intl.dart';

class Herramientas {
  static const double _radioTierra = 6371000;
  static const double _radianes = pi/180;

  double distancia(double lat1, double lon1, double lat2, double lon2){
    
    return 2 * _radioTierra * (asin(sqrt(pow(sin(_radianes * (lat2 - lat1)/2), 2) 
            + (cos(_radianes * lat1) * cos(_radianes * lat2) * pow(sin(_radianes * 
            (lon2 - lon1)/2), 2)))));
     
  }

  String getDia(){
       List<String> dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
       return dias[DateTime.now().weekday - 1];
  }

  String getHora(){
    var now = new DateTime.now();
    var formatter = new DateFormat('HH:mm');
    return formatter.format(now);
  }

   String getFecha(){
    var now = new DateTime.now();
    var formatter = new DateFormat('yyyy-MM-dd');
    return formatter.format(now);
  }




  








}