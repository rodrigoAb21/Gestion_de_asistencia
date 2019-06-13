import 'package:app_movil/src/pages/home_page.dart';
import 'package:app_movil/src/pages/login_page.dart';
import 'package:app_movil/src/pages/settings_page.dart';
import 'package:app_movil/src/util/preferencias_usuario.dart';
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
                image: AssetImage('assets/menu-img.png'),
                fit: BoxFit.cover
              )
            ),
          ),
          ListTile(
            leading: Icon(Icons.home, color: Colors.blueGrey[900],),
            title: Text('Principal'),
            onTap: (){
              Navigator.pushReplacementNamed(context, HomePage.routeName);
            },
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.account_box, color: Colors.blueGrey[900],),
            title: Text('Cuenta'),
            onTap: (){},
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.subdirectory_arrow_right, color: Colors.blueGrey[900],),
            title: Text('Asignaciones'),
            onTap: (){},
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.alarm_on, color: Colors.blueGrey[900],),
            title: Text('Horarios'),
            onTap: (){},
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.settings, color: Colors.blueGrey[900],),
            title: Text('Configuraciones'),
            onTap: (){
              Navigator.pushReplacementNamed(context, SettingsPage.routeName);
            },
          ), 
          Divider(),
          ListTile(
            leading: Icon(Icons.exit_to_app, color: Colors.blueGrey[900],),
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

}