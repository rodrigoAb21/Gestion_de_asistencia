import 'package:and_x/src/models/cliente_model.dart';
import 'package:and_x/src/pages/cliente_page.dart';
import 'package:and_x/src/widgets/menu_widget.dart';
import 'package:flutter/material.dart';

class ListaClientesPage extends StatelessWidget {


  static final String routeName = 'lista_clientes';

  @override
  Widget build(BuildContext context) {

    final List<Cliente> lista = ModalRoute.of(context).settings.arguments;

    return Scaffold(
      appBar: AppBar(
        title: Text('Clientes'),
        centerTitle: true,
        backgroundColor: Colors.blue,
      ),
      drawer: MenuWidget(),
      body: ListView(
        children: _cargarLista(context,lista),
      ),
    );
  }

  List<Widget> _cargarLista(BuildContext context, List<Cliente> lista) {
    List<Widget> list = [];
    for (var item in lista) {
      list.add(ListTile(
        title: Text(item.nombre),
        subtitle: Text(item.direccion),
        onTap: (){
          Navigator.pushNamed(context, ClientePage.routeName,arguments: item);
        },
        ));
        list.add(Divider());
    }
    return list;
  }
}