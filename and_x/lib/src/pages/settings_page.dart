import 'package:and_x/src/widgets/menu_widget.dart';
import 'package:flutter/material.dart';

class SettingsPage extends StatelessWidget {

  static final String routeName = 'settings';

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Preferencias'),
        centerTitle: true,
        backgroundColor: Colors.blue,
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