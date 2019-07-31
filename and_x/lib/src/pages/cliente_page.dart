import 'package:and_x/src/models/cliente_model.dart';
import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong/latlong.dart';

class ClientePage extends StatefulWidget {
  static final String routeName = 'cliente';

  @override
  _ClientePageState createState() => _ClientePageState();
}

class _ClientePageState extends State<ClientePage> {
 @override
  Widget build(BuildContext context) {
    
    final Cliente args = ModalRoute.of(context).settings.arguments;


    return Scaffold(
      appBar: AppBar(
        title: Text("Detalle Cliente"),
        centerTitle: true,
        backgroundColor: Colors.blue,
      ),
      body: Container(
        child: ListView(
          children: <Widget>[
            _mapa(context, args),
            //Container(color: Colors.blue,height: MediaQuery.of(context).size.height/1.85,width: double.infinity),
            SizedBox(height: 10.0),
            // detalle
            ListTile(
              title: Text("Nombre"),
              subtitle: Text(args.nombre),
            ),
            ListTile(
              title: Text("Direccion"),
              subtitle: Text(args.direccion),
            ),
            ListTile(
              title: Text("Telefono"),
              subtitle: Text(args.telefono),
            ),
          ],
        ),
      )
    );
  }

  


  Widget _mapa(BuildContext context, Cliente args){
    return new Container(
              height: MediaQuery.of(context).size.height/1.85,
              width: double.infinity,
              child: new FlutterMap(
                options: new MapOptions(
                center: new LatLng(args.latitud, args.longitud),
                zoom: 18.0),
                layers: [
              new TileLayerOptions(
                urlTemplate:
                      "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                  subdomains: ['a', 'b', 'c']), 
              new MarkerLayerOptions(markers: [
                new Marker(
                    width: 45.0,
                    height: 45.0,
                    point: new LatLng(args.latitud, args.longitud),
                    builder: (context) => new Container(
                          child: IconButton(
                            icon: Icon(Icons.location_on),
                            color: Colors.red,
                            iconSize: 45.0,
                            onPressed: () {
                              print('Marker tapped');
                            },
                          ),
                        ))
              ])
            ]),
            );
  }


}





/*

 urlTemplate:"https://api.mapbox.com/styles/v1/rodrigoab21/cjlzvgwo16pug2rns311bjd9i/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1Ijoicm9kcmlnb2FiMjEiLCJhIjoiY2psenZmcDZpMDN5bTNrcGN4Z2s2NWtqNSJ9.bSdjQfv-28z1j4zx7ljvcg",
                  additionalOptions: {
                    'accessToken':'pk.eyJ1Ijoicm9kcmlnb2FiMjEiLCJhIjoiY2psenZmcDZpMDN5bTNrcGN4Z2s2NWtqNSJ9.bSdjQfv-28z1j4zx7ljvcg',
                    'id': 'mapbox.mapbox-streets-v7'
                  }),

 */