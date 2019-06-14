import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:app_movil/src/widgets/menu_widget.dart';
import 'package:local_auth/local_auth.dart';

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
    bool isAuthorized = false;
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
      // autenticado
    } else {
      //no autenticado
    }

  }


}