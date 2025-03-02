import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_mobile_apps/features/product/domain/repositories/product_repository.dart';
import 'package:tsth_mobile_apps/features/product/presentation/bloc/product_event.dart';
import 'package:tsth_mobile_apps/features/product/presentation/bloc/product_state.dart';

class ProductBloc extends Bloc<ProductEvent, ProductState> {
  final ProductRepository repository;

  ProductBloc(this.repository) : super(ProductInitial()) {
    on<LoadProducts>((event, emit) async {
      emit(ProductLoading());
      try {
        final products = await repository.getProducts();
        emit(ProductLoaded(products));
      } catch (e) {
        emit(ProductError(e.toString()));
      }
    });
  }
}
