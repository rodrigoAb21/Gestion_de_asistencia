import 'package:app_movil/src/models/cliente_model.dart';
import 'package:app_movil/src/widgets/menu_widget.dart';
import 'package:flutter/material.dart';

class ListaClientesPage extends StatelessWidget {


  static final String routeName = 'lista_clientes';

  @override
  Widget build(BuildContext context) {

    List<Cliente> lista = [];
    for (var i = 0; i < 10; i++) {
      lista.add(new Cliente('Juan Perez', 'Lejos', '2142341', 16.231, 23.12));
    }

    return Scaffold(
      appBar: AppBar(
        title: Text('Clientes'),
        centerTitle: true,
        backgroundColor: Colors.blue,
      ),
      drawer: MenuWidget(),
      body: ListView(
        children: _cargarLista(lista),
      ),
    );
  }

  List<Widget> _cargarLista(List<Cliente> lista) {
    List<Widget> list = [];
    for (var item in lista) {
      list.add(ListTile(
        title: Text(item.nombre),
        subtitle: Text(item.direccion),
        ));
    }
    return list;
  }
}