import { Routes } from '@angular/router';
import { ConcertHallComponent } from './concert-hall/concert-hall.component';
import { FileUploadComponent } from './file-upload/file-upload.component';

export const routes: Routes = [
    { path: 'concert-hall', component: ConcertHallComponent },
    { path: 'file-upload', component: FileUploadComponent },
    { path: '', redirectTo: '/file-upload', pathMatch: 'full' }
  ];