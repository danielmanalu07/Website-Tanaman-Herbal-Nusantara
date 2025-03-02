import 'package:flutter/material.dart';
import 'package:tsth_mobile_apps/features/product/domain/entities/product.dart';

class ProductCard extends StatelessWidget {
  final Product product;

  const ProductCard({super.key, required this.product});

  @override
  Widget build(BuildContext context) {
    return Card(
      child: Column(
        children: [
          Image.network(
            product.imageUrl,
            height: 100,
            width: 100,
            fit: BoxFit.cover,
          ),
          Text("\$${product.price.toStringAsFixed(2)}")
        ],
      ),
    );
  }
}
