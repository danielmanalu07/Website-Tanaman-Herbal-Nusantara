import 'package:tsth_app/features/authentication/domain/entities/user.dart';
import 'package:tsth_app/features/authentication/domain/repositories/auth_repository.dart';

class LoginStaff {
  final AuthRepository authRepository;

  LoginStaff(this.authRepository);

  Future<User> call(String username, String password) {
    return authRepository.login(username, password);
  }
}
