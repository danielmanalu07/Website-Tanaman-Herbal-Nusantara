import 'package:tsth_mobile_apps/features/dashboard/domain/repositories/user_repository.dart';

class LogoutUsecase {
  final UserRepository userRepository;

  LogoutUsecase(this.userRepository);

  Future<void> execute() async {
    return await userRepository.logout();
  }
}
