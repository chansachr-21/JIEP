// TypeScript interfaces untuk INDUSTRIA

export interface IndustrialEstate {
  id: number
  name: string
  slug: string
  description: string | null
  manager_name: string | null
  address: string | null
  city: string | null
  province: string | null
  area_hectares: string | null
  established_year: number | null
  established_date: string | null
  ownership_pemprov_pct: string | null
  ownership_danareksa_pct: string | null
  website: string | null
  phone: string | null
  phone_secondary: string | null
  email: string | null
  latitude: string | null
  longitude: string | null
  verification_status: VerificationStatus
  data_source: string | null
  source_url: string | null
  last_verified_at: string | null
  created_at: string
  updated_at: string
}

export interface Company {
  id: number
  industrial_estate_id: number
  name: string
  slug: string
  category: string | null
  description: string | null
  address: string | null
  phone: string | null
  email: string | null
  website: string | null
  latitude: string | null
  longitude: string | null
  verification_status: VerificationStatus
  data_source: string | null
  source_url: string | null
  last_verified_at: string | null
  is_featured: boolean
  is_active: boolean
  created_at: string
  updated_at: string
}

export interface Facility {
  id: number
  industrial_estate_id: number
  name: string
  category: string
  description: string | null
  address: string | null
  latitude: string | null
  longitude: string | null
  operational_status: string
  phone: string | null
  verification_status: VerificationStatus
  data_source: string | null
  source_url: string | null
  last_verified_at: string | null
  is_active: boolean
  created_at: string
  updated_at: string
}

export interface AccessPoint {
  id: number
  industrial_estate_id: number
  name: string
  road_name: string | null
  description: string | null
  latitude: string | null
  longitude: string | null
  verification_status: VerificationStatus
  data_source: string | null
  source_url: string | null
  created_at: string
  updated_at: string
}

export interface Complaint {
  id: number
  complaint_number: string
  title: string
  category: string
  description: string
  location: string | null
  reporter_name: string | null
  status: ComplaintStatus
  is_demo: boolean
  status_histories: ComplaintStatusHistory[]
  created_at: string
  updated_at: string
}

export interface ComplaintStatusHistory {
  id: number
  complaint_id: number
  status: ComplaintStatus
  note: string | null
  created_at: string
}

export interface JobVacancy {
  id: number
  company_id: number | null
  company_name: string
  title: string
  category: string | null
  description: string | null
  requirements: string | null
  employment_type: string | null
  location: string | null
  is_published: boolean
  is_demo: boolean
  published_at: string | null
  deadline: string | null
  source_url: string | null
  data_source: string | null
  verification_status: VerificationStatus
  created_at: string
  updated_at: string
}

export interface Announcement {
  id: number
  industrial_estate_id: number | null
  title: string
  category: string
  content: string
  is_official: boolean
  is_demo: boolean
  is_published: boolean
  published_at: string | null
  source_url: string | null
  data_source: string | null
  verification_status: VerificationStatus
  created_at: string
  updated_at: string
}

export interface ActivityLog {
  id: number
  action: string
  table_name: string
  record_id: number | null
  old_values: Record<string, any> | null
  new_values: Record<string, any> | null
  description: string | null
  ip_address: string | null
  created_at: string
}

export interface MapLocation {
  id: string
  type: 'estate' | 'company' | 'facility' | 'access' | 'infrastructure'
  label: string
  name: string
  latitude: number
  longitude: number
  description: string | null
  category?: string
  verification_status: VerificationStatus
  link_id?: number
}

export interface PaginatedResponse<T> {
  data: T[]
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number | null
  to: number | null
  links: { url: string | null; label: string; active: boolean }[]
}

export type VerificationStatus = 'verified' | 'needs_verification' | 'unverified'
export type ComplaintStatus = 'diterima' | 'ditinjau' | 'diproses' | 'selesai' | 'ditolak'

export interface DashboardStats {
  summary: {
    total_companies: number
    verified_companies: number
    total_facilities: number
    total_complaints: number
    open_complaints: number
    total_jobs: number
    active_jobs: number
    total_announcements: number
  }
  complaints_by_status: Record<ComplaintStatus, number>
  companies_by_category: { category: string; count: number }[]
  verification_stats: {
    companies: Record<VerificationStatus, number>
    facilities: Record<VerificationStatus, number>
  }
  recent_complaints_chart: { date: string; count: number }[]
}
