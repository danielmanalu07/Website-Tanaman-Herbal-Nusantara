import Admin from "../models/Admin";
import Staff from "../models/Staff";

export interface AdminRepository {
  //Authentication Admin
  findByUsername(username: string): Promise<Admin | null>;
  currentUser(id: number): Promise<Admin | null>;
  logout(id: number): Promise<Admin | null>;
  refreshToken(refreshToken: string): Promise<string>;

  //CRUD Account Staff
  createStaff(staff: Staff): Promise<Staff | null>;
}
