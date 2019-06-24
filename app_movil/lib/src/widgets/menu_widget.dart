import 'package:app_movil/src/models/cliente_model.dart';
import 'package:app_movil/src/models/dia_model.dart';
import 'package:app_movil/src/models/horario_model.dart';
import 'package:app_movil/src/models/ubicacion_model.dart';
import 'package:app_movil/src/pages/home_page.dart';
import 'package:app_movil/src/pages/horarios_page.dart';
import 'package:app_movil/src/pages/listaClientes_page.dart';
import 'package:app_movil/src/pages/login_page.dart';
import 'package:app_movil/src/pages/settings_page.dart';
import 'package:app_movil/src/pages/ubicacion_page.dart';
import 'package:app_movil/src/util/preferencias_usuario.dart';
import 'dart:convert' as convert;
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';

class MenuWidget extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Drawer(
      child: ListView(
        padding: EdgeInsets.zero,
        children: <Widget>[
          DrawerHeader(
            child: Container(),
            decoration: BoxDecoration(
              image: DecorationImage(
                image: AssetImage('assets/menu-img.jpg'),
                fit: BoxFit.cover
              )
            ),
          ),
          ListTile(
            leading: Icon(Icons.home, color: Colors.blue,),
            title: Text('Principal'),
            onTap: (){
              Navigator.pushReplacementNamed(context, HomePage.routeName);
            },
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.account_box, color: Colors.blue,),
            title: Text('Cuenta'),
            onTap: (){},
          ),
          Divider(),
          ListTile(
            leading: Icon(Icons.business, color: Colors.blue,),
            title: Text('Ubicacion'),
            onTap: (){
              _getUbicacion(context);
            },
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.group, color: Colors.blue,),
            title: Text('Clientes'),
            onTap: (){
              _getClientes(context);
            },
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.alarm_on, color: Colors.blue,),
            title: Text('Horarios'),
            onTap: (){
              _getHorarios(context);
            },
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.settings, color: Colors.blue,),
            title: Text('Configuraciones'),
            onTap: (){
              Navigator.pushReplacementNamed(context, SettingsPage.routeName);
            },
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.exit_to_app, color: Colors.blue,),
            title: Text('Log out'),
            onTap: (){
              //enviar logout             
              _logout(context);
            },
          ), 
          Divider(),
          

        ],
      ),
    );
  }


  _logout(BuildContext context) async {
    final prefs = new PreferenciasUsuario();
    final resp = await http.post('http://testsoft.nl/api/logout', headers: {
      "Accept": "application/json",
      "Authorization": prefs.token}
    );

    if(resp.statusCode == 204){
      final prefs = new PreferenciasUsuario();
      prefs.token = '';
      Navigator.pushReplacementNamed(context, LoginPage.routeName);
    }

  }

  _getUbicacion(BuildContext context) async {
    final prefs = new PreferenciasUsuario();
    final resp = await http.get('http://testsoft.nl/api/ubicacion', headers: {
      "Accept": "application/json",
      "Authorization": prefs.token}
    );
    if(resp.statusCode == 200){
      var decodedResp = convert.jsonDecode(resp.body);
      Navigator.pushReplacementNamed(
        context, 
        UbicacionPage.routeName,
        arguments: Ubicacion(
          decodedResp['nombre'], 
          decodedResp['direccion'], 
          decodedResp['telefono'], 
          decodedResp['latitud'], 
          decodedResp['longitud']));
    }
  }


  _getClientes(BuildContext context) async {
    final prefs = new PreferenciasUsuario();
    final resp = await http.get('http://testsoft.nl/api/clientes', headers: {
      "Accept": "application/json",
      "Authorization": prefs.token}
    );
    if(resp.statusCode == 200){
      List<Cliente> lista = [];
      List<dynamic> decodedResp = convert.jsonDecode(resp.body);
      decodedResp.forEach((item) => 
        lista.add(
          Cliente(
            item['nombre'], 
            item['direccion'], 
            item['telefono'], 
            item['latitud'], 
            item['longitud']
          )
        )
      );
      Navigator.pushReplacementNamed(context, ListaClientesPage.routeName, arguments: lista);
    }
  }

  _getHorarios(BuildContext context) async {
    final prefs = new PreferenciasUsuario();
    final resp = await http.get('http://testsoft.nl/api/horarios', headers: {
      "Accept": "application/json",
      "Authorization": prefs.token}
    );
    if(resp.statusCode == 200){
      List<Horario> lista = [];
      List<dynamic> decodedResp = convert.jsonDecode(resp.body);
      decodedResp.forEach((item) => 
        lista.add(_getHorario(item['nombre'], item['turno'],convert.jsonDecode(convert.jsonEncode(item['dias']))))
      );
      Navigator.pushReplacementNamed(context, HorariosPage.routeName, arguments: lista);
    }
  }

  Horario _getHorario(String nombre, String turno, List<dynamic> decodedResp){
    List<Dia> dias = [];
    decodedResp.forEach((item) => 
      dias.add(
        Dia(item['nombre'], item['entrada'], item['salida'])
      )
    );
    return Horario(nombre, turno, dias);
  }

}