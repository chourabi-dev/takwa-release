import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class Api {
  String server = 'localhost:8000';

 

  Future<http.Response> auth(String accessCode) async {
    var path =  '/mobile/api/auth';

    var uri = Uri.http(server, path, {  });

    return http.post(uri, body: {'access_code': accessCode});
  }




  Future<http.Response> info(  ) async {
    final prefs = await SharedPreferences.getInstance();

    var token = prefs.getString('token');  
    var path =  '/mobile/api/info'; 
    var uri = Uri.http(server, path, {  }); 
 
    return http.get(uri, headers: { 'Authorization':token! },  );
  }





  Future<http.Response> myTrips(  ) async {
    final prefs = await SharedPreferences.getInstance();

    var token = prefs.getString('token');  
    var path =  '/mobile/api/trips'; 
    var uri = Uri.http(server, path, {  }); 
 
    return http.get(uri, headers: { 'Authorization':token! },  );
  }


  Future<http.Response> saveFCM( String fcm ) async {
    final prefs = await SharedPreferences.getInstance();

    var token = prefs.getString('token');  
    var path =  '/mobile/api/save-fcm'; 
    var uri = Uri.http(server, path, {  }); 
 
    return http.post(uri, headers: { 'Authorization':token! }, body: { 'fcm': fcm }  );
  }



    Future<http.Response> updateTripStatus( int id, int status ) async {
    final prefs = await SharedPreferences.getInstance();

    var token = prefs.getString('token');  
    var path =  '/mobile/api/update-trip-status'; 
    var uri = Uri.http(server, path, {  }); 
 
    return http.post(uri, headers: { 'Authorization':token! }, body: { 'id':'${id}', 'status': '${status}' }  );
  }






}