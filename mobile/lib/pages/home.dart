import 'dart:convert';

import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter/widgets.dart';
import 'package:mobile/api/api.dart';
import 'package:mobile/firbase_config.dart';
import 'package:mobile/pages/login.dart';
import 'package:shared_preferences/shared_preferences.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {

  Api _api = new Api();

  dynamic user = null;


  List<dynamic> _trips = [];
  bool _loading = false;
    




  getMyInfo(){
    _api.info().then((res){
      final body = json.decode(res.body);


      print(body);

      setState(() {
        user = body;
      });

    }).catchError((err){
      print(err);
    });
  }



  getFCM() async {
           
     await Firebase.initializeApp(
      options: DefaultFirebaseOptions.currentPlatform
     );
     
    FirebaseMessaging.instance.getToken().
    then((fcmToken) {
    
      print(fcmToken); 
      _api.saveFCM(fcmToken!).then((res){  });  
    }).catchError((err){
      print(err);
    });
  }


  getTrips(){
    setState(() {
      _loading = true;
    });
    _api.myTrips().then((res){
      final body = json.decode(res.body);

      print(body);
      setState(() {
        _trips = body;
      });

    }).catchError((err){

    }).then((value) => setState(() {
      _loading = false;
    }));
  }

  @override
  void initState() {
    // TODO: implement initState
    super.initState();
    getMyInfo();
    getFCM();
    getTrips();
  }



  _updateTripStatus(int id, int status){
    
    setState(() {
      _loading = true;
    });

    _api.updateTripStatus(id, status).then((value){
      print(value.body);
      
      getTrips();

    }).catchError((err){
      print(err);

      getTrips();
    });
  }





 



  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Page d'accueil"),
        actions: [
          IconButton(onPressed: ()async{
            // clear token from sharedpref
            await SharedPreferences.getInstance().then((prefs){
              prefs.remove('token');
              
                    Navigator.pushReplacement(context, new MaterialPageRoute(builder: (ctx){
                      return LoginScreen();
                    }));

            });

          }, icon: Icon(Icons.exit_to_app,color: Colors.red.shade300,))
        ],
      ),



      /* [{0: 0, createdAt: 27/05/24 13:07, status: 0, destination: jerba, contact_name: chourabi taher, check_in: 25/05/24
16:12, check_out: 26/05/24 16:12, places: 80, phone: 93863732, email: tchourabi@gmail.com}]*/
      body: _loading == true ? Center( child:  CircularProgressIndicator(),) : ListView.builder(itemCount: _trips.length, itemBuilder: (context, index) {
        return  _trips[index]['status'] != 2 ?   Container(
            margin: EdgeInsets.all(15),
            child: InkWell(
              onTap: (){

              },
              child: Card(
            child: Container(
              padding: EdgeInsets.all(10),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(_trips[index]['destination'], style: TextStyle( 
                    fontSize: 20,
                    fontWeight: FontWeight.bold
                   ), ),
                   SizedBox(height: 12,),

                   Text(_trips[index]['createdAt'], style: TextStyle( 
                    fontSize: 13, 
                    color: Colors.blue.shade500
                   ), ),
                   SizedBox(height: 12,),

                   Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                        Text(_trips[index]['check_in'], style: TextStyle( 
                          fontSize: 12, 
                          color: Colors.grey
                        ), ),

                          Text(_trips[index]['check_out'], style: TextStyle( 
                            fontSize: 12, 
                            color: Colors.grey
                          ), ),
                    ],
                   ) ,
                 
                   SizedBox(height: 15,),
                   
                   Text( '${_trips[index]['places']} persone(s)' , style: TextStyle( 
                    fontSize: 12, 
                    color: Colors.grey
                   ), ),
                   SizedBox(height: 15,),

                   Text('Organisateur: ${_trips[index]['contact_name']}', style: TextStyle( 
                    fontSize: 12, 
                    color: Colors.grey
                   ), ),
                   SizedBox(height: 15,),

                   Text('Télephone: ${_trips[index]['phone']}', style: TextStyle( 
                    fontSize: 12, 
                    color: Colors.grey
                   ), ),
                   SizedBox(height: 15,),
                   
                   Row(
                    children: [

                      _trips[index]['status'] == 0 ? 
                      TextButton(
                        onPressed: (){
                            _updateTripStatus(_trips[index]['id'], 1);
                        },
                        child: Text('Commencer'),
                      ): Container()
                      

                      ,

                       _trips[index]['status'] == 1 ? 
                      TextButton(
                        onPressed: (){
                          _updateTripStatus(_trips[index]['id'], 2);
                        },
                        child: Text('Colturer'),
                      ): Container()
                      
                    ],
                   )
                   
                   
                   
                   
                ],
              ),
            ),
          ),
            )
          
          
        ) : null;
      },) ,
      drawer: Drawer(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [ 
            DrawerHeader(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                   
                  Text(user != null ? user['fullname'] : 'Chargement...',style: TextStyle( fontSize: 20, fontWeight: FontWeight.bold),),

                  Text(user != null ? user['email'] : 'Chargement...'),
                  
                ],
              ),
              
            )
          ],
        ),
      ),
    );
  }
}