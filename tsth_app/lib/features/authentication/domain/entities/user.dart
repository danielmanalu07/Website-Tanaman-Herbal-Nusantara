class User {
  final int id;
  final String fullName;
  final String email;
  final String phone;
  final String username;
  final bool active;
  final List<String> roles;
  final List<String> permissions;

  User({
    required this.id,
    required this.fullName,
    required this.email,
    required this.phone,
    required this.username,
    required this.active,
    required this.roles,
    required this.permissions,
  });
}
