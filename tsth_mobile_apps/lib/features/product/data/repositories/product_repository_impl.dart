import 'package:tsth_mobile_apps/features/product/domain/entities/product.dart';
import 'package:tsth_mobile_apps/features/product/domain/repositories/product_repository.dart';

class ProductRepositoryImpl implements ProductRepository {
  @override
  Future<List<Product>> getProducts() async {
    await Future.delayed(const Duration(seconds: 1));
    return [
      Product(
          id: '1',
          name: 'Product A',
          price: 10.0,
          imageUrl:
              'https://www.myredboxx.com/wp-content/uploads/2020/09/DSC5991-1-scaled.jpg'),
      Product(
          id: '2',
          name: 'Product B',
          price: 20.0,
          imageUrl:
              'https://www.myredboxx.com/wp-content/uploads/2020/09/DSC5991-1-scaled.jpg'),
      Product(
          id: '3',
          name: 'Product C',
          price: 30.0,
          imageUrl:
              'https://www.myredboxx.com/wp-content/uploads/2020/09/DSC5991-1-scaled.jpg'),
    ];
  }
}
