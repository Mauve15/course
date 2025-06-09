// import { NavFooter } from '@/components/nav-footer';
// import { NavMain } from '@/components/nav-main';
// import { NavUser } from '@/components/nav-user';
// import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
// import { type NavItem } from '@/types';
// import { Link } from '@inertiajs/react';
// import { BookOpen, Folder, LayoutGrid } from 'lucide-react';
// import AppLogo from './app-logo';

// const mainNavItems: NavItem[] = [
//     {
//         title: 'Dashboard',
//         href: '/dashboard',
//         icon: LayoutGrid,
//     },
//     {
//         title: 'Student',
//         href: '/student',
//         icon: LayoutGrid,
//     },
//     {
//         title: 'Jadwal',
//         href: '/jadwal',
//         icon: LayoutGrid,
//     },
//     {
//         title: 'Pembayaran',
//         href: '/pembayaran',
//         icon: LayoutGrid,
//     },
//     {
//         title: 'Pendaftaran',
//         href: '/pendaftaran',
//         icon: LayoutGrid,
//     },
//     {
//         title: 'Pengaturan',
//         href: '/pengaturan',
//         icon: LayoutGrid,
//     },
// ];

// const footerNavItems: NavItem[] = [
//     {
//         title: 'Repository',
//         href: 'https://github.com/laravel/react-starter-kit',
//         icon: Folder,
//     },
//     {
//         title: 'Documentation',
//         href: 'https://laravel.com/docs/starter-kits#react',
//         icon: BookOpen,
//     },
// ];

// export function AppSidebar() {
//     return (
//         <Sidebar collapsible="icon" variant="inset">
//             <SidebarHeader>
//                 <SidebarMenu>
//                     <SidebarMenuItem>
//                         <SidebarMenuButton size="lg" asChild>
//                             <Link href="/dashboard" prefetch>
//                                 <AppLogo />
//                             </Link>
//                         </SidebarMenuButton>
//                     </SidebarMenuItem>
//                 </SidebarMenu>
//             </SidebarHeader>

//             <SidebarContent>
//                 <NavMain items={mainNavItems} />
//             </SidebarContent>

//             <SidebarFooter>
//                 <NavFooter items={footerNavItems} className="mt-auto" />
//                 <NavUser />
//             </SidebarFooter>
//         </Sidebar>
//     );
// }
import { usePage } from '@inertiajs/react';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import {
  LayoutDashboard,
  Users,
  CalendarDays,
  CreditCard,
  FileText,
  BookOpen,
  ReceiptText,
  FileWarning,
  ClipboardList,
} from 'lucide-react';

import AppLogo from './app-logo';

const allNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
    icon: LayoutDashboard, // Ikon dashboard
  },
  {
    title: 'Student',
    href: '/student',
    icon: Users, // Ikon untuk pengguna/siswa
  },
  {
    title: 'Jadwal',
    href: '/jadwal',
    icon: CalendarDays, // Ikon kalender
  },
  {
    title: 'Pembayaran',
    href: '/pembayaran',
    icon: CreditCard, // Ikon pembayaran
  },
  {
    title: 'Pendaftaran',
    href: '/pendaftaran',
    icon: FileText, // Ikon form/file
  },
  {
    title: 'Brosur',
    href: '/brosur',
    icon: BookOpen, // Ikon buku/brosur
  },
  {
    title: 'Biaya',
    href: '/biaya',
    icon: ReceiptText, // Ikon tagihan/kwitansi
  },
  {
    title: 'Persyaratan',
    href: '/persyaratan',
    icon: FileWarning, // Ikon dokumen persyaratan
  },
  
  {
    title: 'Rekap',
    href: '/rekap',
    icon: ClipboardList, // Ikon rekap/laporan
  },
];



const footerNavItems: NavItem[] = [
//   {
//     title: 'Repository',
//     href: 'https://github.com/laravel/react-starter-kit',
//     icon: Folder,
//   },
//   {
//     title: 'Documentation',
//     href: 'https://laravel.com/docs/starter-kits#react',
//     icon: BookOpen,
//   },
];

export function AppSidebar() {
  const { auth } = usePage().props as any;
  const role = auth?.user?.role;

const roleBasedAccess: Record<string, string[]> = {
  user: ['Dashboard', 'Pendaftaran', 'Brosur', 'Biaya', 'Persyaratan'],
  pengajar: ['Dashboard', 'Jadwal', 'Student', 'Rekap'],
  siswa: ['Dashboard', 'Pembayaran', 'Jadwal', 'Rekap'],
};
const allowedTitles = roleBasedAccess[role] ?? null;

const mainNavItems = allowedTitles
  ? allNavItems.filter(item => allowedTitles.includes(item.title))
  : allNavItems;


  return (
    <Sidebar collapsible="icon" variant="inset">
      <SidebarHeader>
        <SidebarMenu>
          <SidebarMenuItem>
            <SidebarMenuButton size="lg" asChild>
              <Link href="/dashboard" prefetch>
                <AppLogo />
              </Link>
            </SidebarMenuButton>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarHeader>

      <SidebarContent>
        <NavMain items={mainNavItems} />
      </SidebarContent>

      <SidebarFooter>
        <NavFooter items={footerNavItems} className="mt-auto" />
        <NavUser />
      </SidebarFooter>
    </Sidebar>
  );
}
