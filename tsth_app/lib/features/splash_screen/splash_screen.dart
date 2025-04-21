import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/core/constant/path_constant.dart';
import 'package:tsth_app/routes/initial_route.dart';

class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  void initState() {
    super.initState();
    // _checkLoginStatus();
    Future.delayed(const Duration(seconds: 2), () {
      context.go(InitialRoute.loginScreen);
    });
  }

  // Future<void> _checkLoginStatus() async {
  //   final isLoggedIn = await AuthUtils.isLoggedIn();
  //   await Future.delayed(const Duration(seconds: 2));
  //   if (!mounted) return;
  //   context.go(isLoggedIn ? InitialRoute.homeScreen : InitialRoute.loginScreen);
  // }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: ColorConstant.backgroundColor,
      body: Center(
        child: Image.asset(
          PathConstant.logo,
          width: double.infinity,
          height: double.infinity,
        ),
      ),
    );
  }
}
