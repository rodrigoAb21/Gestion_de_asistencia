import 'package:and_x/src/pages/cliente_page.dart';
import 'package:and_x/src/pages/home_page.dart';
import 'package:and_x/src/pages/horarios_page.dart';
import 'package:and_x/src/pages/listaClientes_page.dart';
import 'package:and_x/src/pages/login_page.dart';
import 'package:and_x/src/pages/settings_page.dart';
import 'package:and_x/src/pages/ubicacion_page.dart';
import 'package:and_x/src/util/preferencias_usuario.dart';
import 'package:flutter/material.dart';

void main() async {
  final prefs = new PreferenciasUsuario();
  await prefs.initPrefs();
  runApp(MyApp());
}
 
class MyApp extends StatelessWidget {
  final prefs = new PreferenciasUsuario();

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Material App',
      debugShowCheckedModeBanner: false,
      initialRoute: prefs.getPagina(),
      routes: {
        HomePage.routeName : ( BuildContext context ) => HomePage(),
        LoginPage.routeName : ( BuildContext context ) => LoginPage(),
        SettingsPage.routeName : ( BuildContext context ) => SettingsPage(),
        UbicacionPage.routeName : ( BuildContext context ) => UbicacionPage(),
        ListaClientesPage.routeName : ( BuildContext context ) => ListaClientesPage(),
        ClientePage.routeName : ( BuildContext context ) => ClientePage(),
        HorariosPage.routeName : ( BuildContext context ) => HorariosPage(),
      },
    );
  }
}