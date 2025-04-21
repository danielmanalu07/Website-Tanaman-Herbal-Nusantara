import 'dart:convert';

import 'package:tsth_app/core/constant/api_constant.dart';
import 'package:tsth_app/core/utils/auth_utils.dart';
import 'package:tsth_app/features/authentication/data/model/user_model.dart';
import 'package:http/http.dart' as http;

class AuthRemoteDataSource {
  Future<UserModel> login(String username, String password) async {
    final response = await http.post(
      Uri.parse('${ApiConstant.api}/login'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({'username': username, 'password': password}),
    );

    final jsonData = jsonDecode(response.body);
    if (response.statusCode == 200) {
      final data = UserModel.fromJson(jsonData);
      return data;
    } else {
      throw jsonData['message'];
    }
  }

  Future<void> logout() async {
    final token = await AuthUtils.getToken();
    if (token == null || token.isEmpty) {
      throw Exception("Token not found, please login again.");
    }
    final response = await http.post(
      Uri.parse('${ApiConstant.api}/logout'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    final resData = jsonDecode(response.body);
    if (response.statusCode == 200) {
      return await AuthUtils.removeToken();
    } else {
      await AuthUtils.removeToken();
      throw Exception(resData['message']);
    }
  }
}
