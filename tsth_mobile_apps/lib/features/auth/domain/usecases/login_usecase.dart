import 'package:tsth_mobile_apps/features/auth/domain/entities/user.dart';
import 'package:tsth_mobile_apps/features/auth/domain/repositories/auth_repository.dart';

class LoginUsecase {
  final AuthRepository repository;

  LoginUsecase(this.repository);

  Future<User> execute(String username, String password) {
    return repository.login(username, password);
  }
}
