import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_mobile_apps/core/constant/color_constant.dart';
import 'package:tsth_mobile_apps/core/widgets/custom_snackbar.dart';
import 'package:tsth_mobile_apps/features/dashboard/presentation/bloc/dashboard_bloc.dart';
import 'package:tsth_mobile_apps/features/dashboard/presentation/bloc/dashboard_event.dart';
import 'package:tsth_mobile_apps/features/dashboard/presentation/bloc/dashboard_state.dart';
import 'package:tsth_mobile_apps/features/dashboard/presentation/widgets/custom_card.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_bloc.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_event.dart';
import 'package:tsth_mobile_apps/router/initial_router.dart';

class DashboardPage extends StatefulWidget {
  const DashboardPage({super.key});

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  @override
  void initState() {
    super.initState();
    context.read<DashboardBloc>().add(UserEvent());
  }

  Future<void> _handleRefresh() async {
    await Future.delayed(const Duration(seconds: 1));
    context.read<DashboardBloc>().add(RefreshDashboardEvent());
  }

  void _confirmLogout() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: const Text("Logout Confirmation"),
          content: const Text("Are you sure to logout?"),
          actions: [
            TextButton(
              onPressed: () => context.pop(),
              child: const Text("Cancel"),
            ),
            TextButton(
              onPressed: () {
                context.pop();
                context.read<DashboardBloc>().add(LogoutEvent());
                CustomSnackbar.show(context, 'Logout Successfully', false);
              },
              child: const Text("Yes"),
            ),
          ],
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<DashboardBloc, DashboardState>(
      listener: (context, state) {
        if (state is LogoutSuccess) {
          WidgetsBinding.instance.addPostFrameCallback((_) {
            context.go(InitialRouter.loginScreen);
          });
        } else if (state is DashboardError) {
          WidgetsBinding.instance.addPostFrameCallback((_) {
            context.go(InitialRouter.loginScreen);
            CustomSnackbar.show(context, 'Session expired. Try again!', true);
          });
        }
      },
      child: Scaffold(
        appBar: AppBar(
          title: const Text('TSTH2 Pollung'),
          actions: [
            IconButton(
              icon: const Icon(Icons.exit_to_app),
              onPressed: _confirmLogout,
            ),
          ],
          backgroundColor: ColorConstant.background,
          leading: Image.asset(
            "assets/images/logo.png",
            fit: BoxFit.contain,
          ),
        ),
        body: RefreshIndicator(
          onRefresh: _handleRefresh,
          child: BlocBuilder<DashboardBloc, DashboardState>(
            builder: (context, state) {
              if (state is DashboardLoading) {
                return const Center(
                  child: CircularProgressIndicator(),
                );
              } else if (state is DashboardLoaded) {
                return SingleChildScrollView(
                  physics: const AlwaysScrollableScrollPhysics(),
                  child: Padding(
                    padding: const EdgeInsets.symmetric(
                        vertical: 16.0, horizontal: 16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text('Selamat Datang, ${state.user.username}'),
                        const SizedBox(height: 32),
                        CustomCard(
                          image: "assets/images/tanaman.jpg",
                          title: 'Data Tanaman',
                          onPressed: () {
                            print('Navigating to HabitusScreen');
                            Future.microtask(() {
                              context.go(InitialRouter.habitusScreen);
                            });
                          },
                        ),
                        const SizedBox(height: 32),
                        CustomCard(
                          image: "assets/images/tanaman.jpg",
                          title: 'Hasil Validasi Tanaman',
                          onPressed: () {
                            print('Detail Tanaman');
                          },
                        ),
                        const SizedBox(height: 32),
                        CustomCard(
                          image: "assets/images/tanaman.jpg",
                          title: 'Land Plants',
                          onPressed: () {
                            print('Detail Lands');
                          },
                        ),
                      ],
                    ),
                  ),
                );
              } else if (state is DashboardError) {
                return Center(
                  child: Text(state.message),
                );
              }
              return const Center(
                child: CircularProgressIndicator(),
              );
            },
          ),
        ),
      ),
    );
  }
}
