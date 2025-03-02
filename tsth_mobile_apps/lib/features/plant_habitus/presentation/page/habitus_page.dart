import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_mobile_apps/core/widgets/custom_snackbar.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_bloc.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_event.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_state.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/widgets/custom_card_habitus.dart';
import 'package:tsth_mobile_apps/router/initial_router.dart';

class HabitusPage extends StatefulWidget {
  const HabitusPage({super.key});

  @override
  State<HabitusPage> createState() => _HabitusPageState();
}

class _HabitusPageState extends State<HabitusPage> {
  @override
  void initState() {
    super.initState();
    context.read<HabitusBloc>().add(LoadHabitus());
  }

  Future<void> _handleRefresh() async {
    await Future.delayed(const Duration(seconds: 2));
    context.read<HabitusBloc>().add(RefreshHabitusEvent());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'Data Tanaman',
          style: TextStyle(fontWeight: FontWeight.bold),
        ),
        centerTitle: true,
        leading: IconButton(
          onPressed: () {
            context.go(InitialRouter.dashboardScreen);
          },
          icon: const Icon(Icons.arrow_back),
        ),
      ),
      body: BlocListener<HabitusBloc, HabitusState>(
        listener: (context, state) {
          if (state is HabitusError) {
            WidgetsBinding.instance.addPostFrameCallback((_) {
              CustomSnackbar.show(context, state.message, true);
            });
          }
        },
        child: BlocBuilder<HabitusBloc, HabitusState>(
          builder: (context, state) {
            if (state is HabitusLoading) {
              return const Center(child: CircularProgressIndicator());
            } else if (state is HabitusSuccess) {
              return RefreshIndicator(
                onRefresh: _handleRefresh,
                child: ListView.builder(
                  physics: const AlwaysScrollableScrollPhysics(),
                  padding: const EdgeInsets.all(16.0),
                  itemCount: state.habitusList.length,
                  itemBuilder: (context, index) {
                    return Padding(
                      padding: const EdgeInsets.symmetric(vertical: 8.0),
                      child: CustomCardHabitus(
                        name: state.habitusList[index].name,
                        onPressed: () {
                          print("Navigasi ke ${state.habitusList[index].name}");
                        },
                      ),
                    );
                  },
                ),
              );
            } else if (state is HabitusError) {
              return const Center(
                  child: Text("Terjadi kesalahan, silakan coba lagi."));
            }
            return const Center(child: Text("Data tidak ditemukan"));
          },
        ),
      ),
    );
  }
}
