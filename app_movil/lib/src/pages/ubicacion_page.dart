import 'package:app_movil/src/widgets/menu_widget.dart';
import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong/latlong.dart';

class UbicacionPage extends StatefulWidget {
  static final String routeName = 'ubicacion';

  @override
  _UbicacionPageState createState() => _UbicacionPageState();
}

class _UbicacionPageState extends State<UbicacionPage> {
 @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Ubicacion'),
        centerTitle: true,
        backgroundColor: Colors.blue,
      ),
      drawer: MenuWidget(),
      body: new FlutterMap(
            options: new MapOptions(
                center: new LatLng(-17.821926, -63.229354),
                zoom: 18.0),
            layers: [
              new TileLayerOptions(
                  urlTemplate:"https://api.mapbox.com/styles/v1/rodrigoab21/cjlzvgwo16pug2rns311bjd9i/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1Ijoicm9kcmlnb2FiMjEiLCJhIjoiY2psenZmcDZpMDN5bTNrcGN4Z2s2NWtqNSJ9.bSdjQfv-28z1j4zx7ljvcg",
                  additionalOptions: {
                    'accessToken':'pk.eyJ1Ijoicm9kcmlnb2FiMjEiLCJhIjoiY2psenZmcDZpMDN5bTNrcGN4Z2s2NWtqNSJ9.bSdjQfv-28z1j4zx7ljvcg',
                    'id': 'mapbox.mapbox-streets-v7'
                  }),
              new MarkerLayerOptions(markers: [
                new Marker(
                    width: 45.0,
                    height: 45.0,
                    point: new LatLng(-17.821926, -63.229354),
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
            ])
    );
  }
}