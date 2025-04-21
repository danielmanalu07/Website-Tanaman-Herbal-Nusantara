import 'package:tsth_app/core/utils/auth_utils.dart';
import 'package:tsth_app/features/authentication/data/dataSources/auth_remote_data_source.dart';
import 'package:tsth_app/features/authentication/domain/entities/user.dart';
import 'package:tsth_app/features/authentication/domain/repositories/auth_repository.dart';

class AuthRepositoryImpl implements AuthRepository {
  final AuthRemoteDataSource authRemoteDataSource;

  AuthRepositoryImpl(this.authRemoteDataSource);

  @override
  Future<User> login(String username, String password) async {
    final user = await authRemoteDataSource.login(username, password);

    if (user.token.isNotEmpty) {
      await AuthUtils.setToken(user.token);
    } else {
      throw Exception('Invalid Token Received');
    }

    return user;
  }

  @override
  Future<void> logout() async {
    return await authRemoteDataSource.logout();
  }
}
