import 'package:tsth_mobile_apps/features/dashboard/domain/entities/user.dart';

abstract class UserRepository {
  Future<User> getProfile();
  Future<void> logout();
}
