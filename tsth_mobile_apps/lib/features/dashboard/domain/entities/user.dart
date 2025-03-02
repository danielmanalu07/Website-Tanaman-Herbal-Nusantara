import 'package:tsth_mobile_apps/features/dashboard/domain/entities/role.dart';

class User {
  final int? id;
  final String? username;
  final String? password;
  final Role roles;

  User(
      {required this.id,
      required this.username,
      required this.password,
      required this.roles});
}
