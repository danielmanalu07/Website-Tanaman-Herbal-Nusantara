import { request } from "express";
import Staff from "../../../domain/models/Staff";
import { AdminRepository } from "../../../domain/repositories/AdminRepository";
import Password from "../../../utils/Password";

export class CreateStaffUseCase {
  constructor(private adminRepository: AdminRepository) {}
  async execute(staff: Staff): Promise<Staff | null> {
    const newStaff = await this.adminRepository.createStaff(staff);
    if (!newStaff) return null;
    const hashPassword = await Password.PasswordHashing(newStaff.password);
    newStaff.password = hashPassword;
    newStaff.active = true;

    return newStaff;
  }
}
