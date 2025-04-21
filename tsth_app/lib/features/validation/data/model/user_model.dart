import 'package:tsth_app/features/validation/domain/entities/user.dart';

class UserModel extends User {
  UserModel({
    required super.id,
    required super.fullName,
    required super.email,
    required super.phone,
    required super.username,
    required super.active,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      id: json['id'] ?? 0,
      fullName: json['full_name'] ?? '',
      email: json['email'] ?? '',
      phone: json['phone'] ?? '',
      username: json['username'] ?? '',
      active: json['active'] == 1,
    );
  }
}
