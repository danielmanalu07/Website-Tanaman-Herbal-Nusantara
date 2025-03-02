import 'package:tsth_mobile_apps/features/dashboard/domain/entities/role.dart';

class RoleModel extends Role {
  RoleModel({required super.id, required super.name});

  factory RoleModel.fromJson(Map<String, dynamic> json) {
    return RoleModel(
      id: json['id'],
      name: json['name'],
    );
  }
}
