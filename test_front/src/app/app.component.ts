import { Component } from '@angular/core';
import { RouterLink, RouterOutlet } from '@angular/router';
import { FileUploadComponent } from './file-upload/file-upload.component';
import { ConcertHallComponent } from './concert-hall/concert-hall.component';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,FileUploadComponent, ConcertHallComponent,RouterLink],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'test_front';
}
