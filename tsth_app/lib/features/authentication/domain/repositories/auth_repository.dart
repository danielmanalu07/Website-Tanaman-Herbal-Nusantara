import 'package:tsth_app/features/authentication/domain/entities/user.dart';

abstract class AuthRepository {
  Future<User> login(String username, String password);
  Future<void> logout();
}
