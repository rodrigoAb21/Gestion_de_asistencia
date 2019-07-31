import 'package:and_x/src/util/herramientas.dart';
import 'package:and_x/src/util/preferencias_usuario.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:and_x/src/widgets/menu_widget.dart';
import 'package:local_auth/local_auth.dart';
import 'package:geolocator/geolocator.dart';
import 'package:http/http.dart' as http;

class HomePage extends StatefulWidget {
  static final String routeName = 'home';
  
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Principal"),
      ),
      drawer: MenuWidget(),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            RaisedButton(
              onPressed: _authorizeNow,
              child: Text("Marcar"),
              color: Colors.blue,
              textColor: Colors.white,
            ),
          ],
        ),
      ),
    );
  }

  final LocalAuthentication _localAuthentication = LocalAuthentication();

  Future<void> _authorizeNow() async {
    final prefs = new PreferenciasUsuario();
    bool isAuthorized = false;
    Position position;
    try {
      isAuthorized = await _localAuthentication.authenticateWithBiometrics(
        localizedReason: "Use su huella digital para autenticarse",
        useErrorDialogs: true,
        stickyAuth: true,
      );
    } on PlatformException catch (e) {
      print(e);
    }

    if (!mounted) return;

    if (isAuthorized) {
      try {
       
        position = await Geolocator().getCurrentPosition(LocationAccuracy.high);
        
        final asistencia = {
          'fecha'    : Herramientas().getFecha(),
          'dia'      : Herramientas().getDia(),
          'hora'     : Herramientas().getHora(),
          'latitud'  : '${position.latitude}',
          'longitud' : '${position.longitude}',
          'tipo'     : 'Entrada'
        };
        final resp = await http.post('http://testsoft.nl/api/entrada', body: asistencia, headers: {
        "Accept": "application/json",
        "Content-Type": "application/x-www-form-urlencoded",
        "Authorization": prefs.token});
        if(resp.statusCode == 200){
          print('OK!');
        }else{
          print(resp.statusCode);
        }
      } on PlatformException {
        position = null;
        print("ERROR!");
      }
      
    } else {
      //no autenticado
    }

  }


}