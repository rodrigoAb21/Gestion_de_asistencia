import 'package:app_movil/src/models/dia_model.dart';

class Horario {
  String nombre;
  String turno;
  List<Dia> dias;

  Horario(this.nombre, this.turno, this.dias);
}