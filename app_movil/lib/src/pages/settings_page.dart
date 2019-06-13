import 'package:app_movil/src/widgets/menu_widget.dart';
import 'package:flutter/material.dart';

class SettingsPage extends StatelessWidget {

  static final String routeName = 'settings';

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Preferencias'),
        centerTitle: true,
        backgroundColor: Colors.blueGrey[900],
      ),
      drawer: MenuWidget(),
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Text('Settings'),
          Divider()
        ],
      ),
    );
  }
}