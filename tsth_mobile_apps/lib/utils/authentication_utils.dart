import 'package:tsth_mobile_apps/utils/jwt_utils.dart';

class AuthenticationUtils {
  static Future<bool> isLoggedIn() async {
    String? token = await JwtUtils.getToken();

    if (token == null || token.isEmpty) {
      return false;
    }

    return true;
  }
}
