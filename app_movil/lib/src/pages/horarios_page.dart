import 'package:app_movil/src/models/horario_model.dart';
import 'package:app_movil/src/widgets/menu_widget.dart';
import 'package:flutter/material.dart';

class HorariosPage extends StatelessWidget {


  static final String routeName = 'horarios';

  @override
  Widget build(BuildContext context) {

    final List<Horario> lista = ModalRoute.of(context).settings.arguments;

    return Scaffold(
      appBar: AppBar(
        title: Text('Horarios'),
        centerTitle: true,
        backgroundColor: Colors.blue,
      ),
      drawer: MenuWidget(),
      body: ListView(
        children: _cargarLista(context,lista),
      ),
    );
  }

  List<Widget> _cargarLista(BuildContext context, List<Horario> lista) {
    List<Widget> list = [];
    for (var item in lista) {
      list.add(
        Card(
          elevation: 4.0,
          child: Column(
            children: _cargarHorario(item)
          ),
        )
      );
      list.add(SizedBox(height: 30.0));
    }
    return list;
  }

  List<Widget> _cargarHorario(Horario horario) {
    List<Widget> list = [];
    list.add(Text('$horario.nombre - $horario.turno', style: TextStyle(fontWeight: FontWeight.bold)));
    horario.dias.forEach(
      (item) => 
        list.add(
          ListTile(
            title: Text(item.nombre),
            subtitle: Text('$item.entrada - $item.salida'),
          )
        )
      
    );
    list.add(Divider());

    return list;

  }
  
}