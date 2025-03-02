import 'package:tsth_mobile_apps/features/auth/data/datasources/auth_remote_data_source.dart';
import 'package:tsth_mobile_apps/features/auth/domain/entities/user.dart';
import 'package:tsth_mobile_apps/features/auth/domain/repositories/auth_repository.dart';
import 'package:tsth_mobile_apps/utils/jwt_utils.dart';

class AuthRepositoryImpl implements AuthRepository {
  final AuthRemoteDataSource remoteDataSource;

  AuthRepositoryImpl(this.remoteDataSource);

  @override
  Future<User> login(String username, String password) async {
    final user = await remoteDataSource.login(username, password);

    if (user.token != null && user.token!.isNotEmpty) {
      await JwtUtils.writeToken(user.token!);
    } else {
      throw Exception("Invalid token received");
    }
    return user;
  }
}
