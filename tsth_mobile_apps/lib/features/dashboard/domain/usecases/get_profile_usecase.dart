import 'package:tsth_mobile_apps/features/dashboard/domain/entities/user.dart';
import 'package:tsth_mobile_apps/features/dashboard/domain/repositories/user_repository.dart';

class GetProfileUsecase {
  final UserRepository _userRepository;

  GetProfileUsecase(this._userRepository);

  Future<User> execute() async {
    return await _userRepository.getProfile();
  }
}
