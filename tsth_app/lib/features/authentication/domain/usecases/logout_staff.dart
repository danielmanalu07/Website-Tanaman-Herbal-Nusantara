import 'package:tsth_app/features/authentication/domain/repositories/auth_repository.dart';

class LogoutStaff {
  final AuthRepository authRepository;

  LogoutStaff(this.authRepository);

  Future<void> call() {
    return authRepository.logout();
  }
}
