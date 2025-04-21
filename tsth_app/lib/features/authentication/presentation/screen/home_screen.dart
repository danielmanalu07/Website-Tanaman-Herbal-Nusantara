import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/core/constant/path_constant.dart';
import 'package:tsth_app/core/utils/auth_utils.dart';
import 'package:tsth_app/core/widgets/custom_snackbar.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_bloc.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_event.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_state.dart';
import 'package:tsth_app/features/authentication/presentation/widgets/menu_button.dart';
import 'package:tsth_app/routes/initial_route.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  Future<void> _checkLoginStatus() async {
    final isLoggedIn = await AuthUtils.isLoggedIn();
    await Future.delayed(const Duration(seconds: 2));
    if (!mounted) return;
    context.go(isLoggedIn ? InitialRoute.homeScreen : InitialRoute.loginScreen);
  }

  @override
  void initState() {
    super.initState();
    _checkLoginStatus();
  }

  void _showSettingDialog(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: const Text('Setting'),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(15),
          ),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              ListTile(
                leading: const Icon(
                  Icons.logout,
                  color: ColorConstant.grayColor,
                ),
                title: const Text('Logout'),
                onTap: () {
                  context.pop();
                  context.read<AuthBloc>().add(LogoutEvent());
                },
              ),
              ListTile(
                leading: const Icon(
                  Icons.person,
                  color: ColorConstant.grayColor,
                ),
                title: const Text('Get Profile'),
                onTap: () {
                  context.pop(context);
                  CustomSnackbar.alert(
                    context,
                    "Fitur Get Profile belum tersedia",
                    true,
                  );
                },
              ),
            ],
          ),
        );
      },
    );
  }

  void _showLoadingDialog(BuildContext context) {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (_) => const Center(child: CircularProgressIndicator()),
    );
  }

  void _hideDialog(BuildContext context) {
    if (context.canPop()) {
      context.pop();
    }
  }

  @override
  Widget build(BuildContext context) {
    final screenSize = MediaQuery.of(context).size;
    final isSmallScreen = screenSize.width < 600;

    return BlocListener<AuthBloc, AuthState>(
      listener: (context, state) {
        if (state is AuthLoading) {
          _showLoadingDialog(context);
        } else {
          _hideDialog(context);
        }

        if (state is AuthLogoutSucess) {
          CustomSnackbar.alert(context, "Logout Successfully", false);
          Future.delayed(const Duration(milliseconds: 500), () {
            context.go(InitialRoute.loginScreen);
          });
        } else if (state is AuthError) {
          CustomSnackbar.alert(context, state.message, true);
        }
      },
      child: Scaffold(
        body: Container(
          decoration: const BoxDecoration(
            gradient: LinearGradient(
              begin: Alignment.topCenter,
              end: Alignment.bottomCenter,
              colors: [ColorConstant.backgroundColor, ColorConstant.greenColor],
            ),
          ),
          child: SafeArea(
            child: LayoutBuilder(
              builder: (context, constraints) {
                return SingleChildScrollView(
                  physics: const BouncingScrollPhysics(),
                  child: ConstrainedBox(
                    constraints: BoxConstraints(
                      minHeight: constraints.maxHeight,
                    ),
                    child: IntrinsicHeight(
                      child: Column(
                        children: [
                          SizedBox(height: constraints.maxHeight * 0.05),
                          Image.asset(
                            PathConstant.logo,
                            width: screenSize.width * 0.6,
                            height: screenSize.height * 0.3,
                          ),
                          const Spacer(),
                          Padding(
                            padding: EdgeInsets.symmetric(
                              horizontal: screenSize.width * 0.04,
                            ),
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                              children: [
                                MenuButton(
                                  icon: Icons.history,
                                  onPressed: () {
                                    context.go(
                                      InitialRoute.listValidationScreen,
                                    );
                                  },
                                  label: 'History',
                                  angle: -0.3,
                                  bottomPadding: 0,
                                  size:
                                      isSmallScreen
                                          ? screenSize.width * 0.30
                                          : screenSize.width * 0.3,
                                ),
                                MenuButton(
                                  icon: Icons.qr_code_scanner,
                                  onPressed: () {
                                    context.go(InitialRoute.scanQrScreen);
                                  },
                                  label: 'Scan',
                                  angle: 0,
                                  bottomPadding: isSmallScreen ? 30 : 40,
                                  size:
                                      isSmallScreen
                                          ? screenSize.width * 0.30
                                          : screenSize.width * 0.3,
                                ),
                                MenuButton(
                                  icon: Icons.settings,
                                  onPressed: () {
                                    _showSettingDialog(context);
                                  },
                                  label: 'Setting',
                                  angle: 0.3,
                                  bottomPadding: 0,
                                  size:
                                      isSmallScreen
                                          ? screenSize.width * 0.30
                                          : screenSize.width * 0.3,
                                ),
                              ],
                            ),
                          ),
                          SizedBox(height: constraints.maxHeight * 0.15),
                        ],
                      ),
                    ),
                  ),
                );
              },
            ),
          ),
        ),
      ),
    );
  }
}
