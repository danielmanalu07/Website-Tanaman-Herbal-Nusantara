import 'package:tsth_app/features/authentication/domain/entities/user.dart';

class UserModel extends User {
  String token;
  String message;

  UserModel({
    required super.id,
    required super.fullName,
    required super.email,
    required super.phone,
    required super.username,
    required super.active,
    required super.roles,
    required super.permissions,
    required this.message,
    required this.token,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    final userJson = json['user'];
    return UserModel(
      id: userJson['id'],
      fullName: userJson['full_name'],
      email: userJson['email'],
      phone: userJson['phone'],
      username: userJson['username'],
      active: userJson['active'] == 1,
      roles: List<String>.from(userJson['roles'] ?? []),
      permissions: List<String>.from(userJson['permissions'] ?? []),
      message: json['message'],
      token: json['token'],
    );
  }
}
