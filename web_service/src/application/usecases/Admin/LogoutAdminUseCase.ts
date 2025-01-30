import Admin from "../../../domain/models/Admin";
import { AdminRepository } from "../../../domain/repositories/AdminRepository";

export class LogoutAdminUseCase {
  constructor(private adminRepository: AdminRepository) {}

  async execute(id: number): Promise<Admin | null> {
    const admin = await this.adminRepository.logout(id);
    if (!admin) return null;
    return admin;
  }
}
