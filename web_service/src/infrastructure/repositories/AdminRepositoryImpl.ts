import Admin from "../../domain/models/Admin";
import Staff from "../../domain/models/Staff";
import { AdminRepository } from "../../domain/repositories/AdminRepository";
import Utils from "../../utils/Jwt";

export class AdminRepositoryImpl implements AdminRepository {
  async findByUsername(username: string): Promise<Admin | null> {
    const user = await Admin.findOne({
      where: {
        username: username,
      },
    });
    if (!user) return null;
    return user;
  }

  async currentUser(id: number): Promise<Admin | null> {
    const admin = await Admin.findOne({
      where: {
        id: id,
      },
    });
    if (!admin) return null;
    return admin;
  }

  async logout(id: number): Promise<Admin | null> {
    const admin = await Admin.findOne({
      where: {
        id: id,
      },
    });
    if (!admin) return null;
    return admin;
  }
  async refreshToken(refreshToken: string): Promise<string> {
    return refreshToken;
  }

  async createStaff(staff: Staff): Promise<Staff | null> {
    const create = Staff.create(staff);
    if (!create) {
      return null;
    }
    return create;
  }
}
