import 'package:tsth_mobile_apps/features/dashboard/data/model/role_model.dart';
import 'package:tsth_mobile_apps/features/dashboard/domain/entities/user.dart';

class UserModel extends User {
  UserModel({
    required super.id,
    required super.username,
    required super.roles,
  }) : super(password: null);

  factory UserModel.fromJson(Map<String, dynamic> json) {
    List<RoleModel> roles = [];
    if (json['roles'] != null) {
      roles = (json['roles'] as List)
          .map((role) => RoleModel(id: null, name: role))
          .toList();
    }

    return UserModel(
      id: json['data']['id'],
      username: json['data']['username'],
      roles: roles.isNotEmpty ? roles.first : RoleModel(id: null, name: ''),
    );
  }
}
