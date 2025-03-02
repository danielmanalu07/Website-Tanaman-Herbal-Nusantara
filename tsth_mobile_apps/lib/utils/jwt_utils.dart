import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class JwtUtils {
  static const storage = FlutterSecureStorage();

  static Future<String?> getToken() async {
    return await storage.read(key: 'token');
  }

  static Future<void> deleteToken() async {
    return await storage.delete(key: 'token');
  }

  static Future<void> writeToken(String token) async {
    return await storage.write(key: 'token', value: token);
  }
}
