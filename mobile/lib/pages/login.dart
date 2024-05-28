import 'dart:convert';

import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:mobile/api/api.dart';
import 'package:mobile/firbase_config.dart';
import 'package:mobile/pages/home.dart';
import 'package:shared_preferences/shared_preferences.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {

  Api _api = new Api();

  TextEditingController _controller = new TextEditingController();


  bool _loading = false;
  

  bool _connected = true;
  

  String _error= '';


  


  auth(String accessCode) async{
    setState(() {
      _error = '';
      _loading = true;
    });
    _api.auth(accessCode).then((res) async{
       

      final body = json.decode(res.body);

      print(body['success']);

      if( body['success'] == true ){
        // save token
        // navigate to home screen
    // Obtain shared preferences.
    final SharedPreferences prefs = await SharedPreferences.getInstance();
 
        prefs.setString("token", body['token'] );

        // navigate to home screen
        Navigator.pushReplacement(context, new MaterialPageRoute(builder: (ctx){
          return HomePage();
        }));

      }else{
        setState(() {
          _error = body['message'];
        });
      }

    }).catchError((err){
       setState(() {
          _error = "Une erreur s'est produite. Veuillez réessayer.";
        });
      
    }).then((e){
      setState(() {
        _loading = false;
      });
    });
  }


  checkAuth() async{
    final SharedPreferences prefs = await SharedPreferences.getInstance(); 
    String ?token = prefs.getString("token"); 
    if ( ! token!.isEmpty ) {
      setState(() {
        _connected = true;
      });

        Navigator.pushReplacement(context, new MaterialPageRoute(builder: (ctx){
          return HomePage();
        }));


    }   
  }



  getFCMTEST() async{
           
     await Firebase.initializeApp(
      options: DefaultFirebaseOptions.currentPlatform
     );
    

    print("fcm oyyyyyyyyyyyyyyyyyyyyyyyyyyyy");
    FirebaseMessaging.instance.getToken().
    then((fcmToken) {
    
     print(fcmToken);
    });


  }

  @override
  void initState() {
    // TODO: implement initState
    super.initState();

    checkAuth();
    getFCMTEST();

  }

  @override
  Widget build(BuildContext context) {
    return  Scaffold(
      body: Container(
        child: Center(
        child:  Container( 
          height: 350,
          margin:  EdgeInsets.all(25),
          child: Card(
            color: Colors.white,
            child: Container(
              padding: EdgeInsets.all(15),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Text("Bienvenue!", style: TextStyle(fontSize: 30, fontWeight: FontWeight.bold),),
                  SizedBox(height: 15,),
                  Text("Entrez votre code d'accès pour vous connecter"),
                  SizedBox(height: 15,),
                  
                  TextField(
                    controller: _controller,
                    decoration: InputDecoration(
                      
                      border: OutlineInputBorder(borderRadius: BorderRadius.all(Radius.circular(50)))
                    ),
                  ),
                  SizedBox(height: 15,),

 

                  _loading == false ?
                  TextButton(onPressed: (){
                    auth(_controller.text);
                  }, child: const Text("Se connecter")): Center(child: CircularProgressIndicator(),)
                  

                  





                  ,

                  Container(
                    child: 
                    _error != '' ?
                    Container(
                      color: Colors.red.shade300,
                      padding: EdgeInsets.all(15),
                      child: Text(_error),
                    ) : null,
                  )
                ],
              ),
            ) ,
          ),
        )
      ),
      ),
    );
  }
}