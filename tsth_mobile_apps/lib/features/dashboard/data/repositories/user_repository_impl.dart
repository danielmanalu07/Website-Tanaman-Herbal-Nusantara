import 'package:tsth_mobile_apps/features/dashboard/data/datasources/user_remote_data_source.dart';
import 'package:tsth_mobile_apps/features/dashboard/domain/entities/user.dart';
import 'package:tsth_mobile_apps/features/dashboard/domain/repositories/user_repository.dart';

class UserRepositoryImpl implements UserRepository {
  final UserRemoteDataSource userRemoteDataSource;

  UserRepositoryImpl(this.userRemoteDataSource);

  @override
  Future<User> getProfile() async {
    return await userRemoteDataSource.getProfile();
  }

  @override
  Future<void> logout() async {
    return await userRemoteDataSource.logout();
  }
}
