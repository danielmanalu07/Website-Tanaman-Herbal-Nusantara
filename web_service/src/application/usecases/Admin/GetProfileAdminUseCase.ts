import Admin from "../../../domain/models/Admin";
import { AdminRepository } from "../../../domain/repositories/AdminRepository";

export class GetProfileAdminUseCase {
  constructor(private adminRepository: AdminRepository) {}

  async execute(id: number): Promise<Admin | null> {
    const admin = await this.adminRepository.currentUser(id);
    if (!admin) return null;
    return admin;
  }
}
