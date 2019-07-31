import 'package:and_x/src/pages/home_page.dart';
import 'package:and_x/src/util/preferencias_usuario.dart';
import 'dart:convert' as convert;
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';

class LoginPage extends StatefulWidget {

  static final String routeName = 'login';

  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  String _email = '';
  String _password = '';

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('LOGIN'),
        centerTitle: true,
        backgroundColor: Colors.blue,
      ),
      body: ListView(
        padding: EdgeInsets.symmetric(horizontal: 10.0, vertical: 20.0),
        children: <Widget>[
          SizedBox(height: 20),
          _crearEmail(),
          SizedBox(height: 20),
          _crearPassword(),
          SizedBox(
            height: 30,
          ),
          FlatButton(
            child: Text('Login'),
            onPressed: (){
              _enviar();
            },
            color: Colors.blue,
            textColor: Colors.white,
          )
        ],
      ),
    );
  }

  Widget _crearPassword() {
    return TextField(
      obscureText: true,
      decoration: InputDecoration(
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10.0)
        ),
        hintText: 'Password',
        labelText: 'Password',
        icon: Icon(Icons.lock)
      ),
      onChanged: (valor){
        setState(() {
          _password = valor;
        });
      },
    );
  }

  Widget _crearEmail() {
    return TextField(
      keyboardType: TextInputType.emailAddress,
      decoration: InputDecoration(
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(10.0)
        ),
        hintText: 'Email',
        labelText: 'Email',
        icon: Icon(Icons.email)
      ),
      onChanged: (valor){
        setState(() {
          _email = valor;
        });
      },
    );
  }

  _enviar() async {
    final datos = {
      'username': _email,
      'password': _password
    };

    final resp = await http.post('http://testsoft.nl/api/login', body: datos, headers: {
      "Accept": "application/json",
      "Content-Type": "application/x-www-form-urlencoded"}
    );

    var decodedResp = convert.jsonDecode(resp.body);

    if(decodedResp.containsKey('access_token')){
      final prefs = new PreferenciasUsuario();
      prefs.token = 'Bearer ' + decodedResp['access_token'];

      final r2 = await http.get('http://testsoft.nl/api/usuario', headers: {
        "Accept": "application/json",
        "Authorization": prefs.token}
      );
      if(r2.statusCode == 200){
        var decodedResp = convert.jsonDecode(r2.body);
        prefs.nombre = decodedResp['nombre'];
        prefs.email = decodedResp['email'];
        Navigator.pushReplacementNamed(context, HomePage.routeName);
      }
    }



  }

}