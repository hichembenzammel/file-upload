import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component } from '@angular/core';
import * as XLSX from 'xlsx'; 
import { ConcertHallService } from '../services/concert-hall.service';
import { BandService } from '../services/band.service';
import { CommonModule } from '@angular/common';
import { Band } from '../models/Band';
import { ConcertHall } from '../models/hall';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-file-upload',
  standalone: true,
  imports: [HttpClientModule, CommonModule,FormsModule], 
  templateUrl: './file-upload.component.html',
  styleUrls: ['./file-upload.component.css']
})
export class FileUploadComponent {
  fileToUpload: File | null = null;
  bands: Band[] = []; 
  concertHalls: ConcertHall[] = [];
  selectedBandId: number | null = null; 
  selectedConcertHallId: number | null = null; 
  constructor(private http: HttpClient, private bandService: BandService, private concertHallService: ConcertHallService) {}

  onFileChange(event: Event): void {
    const input = event.target as HTMLInputElement;
    if (input && input.files) {
      this.fileToUpload = input.files[0];
      console.log('Selected file:', this.fileToUpload);
    }
  }

 uploadFile(): void {
  if (!this.fileToUpload) {
    console.error('No file selected');
    return;
  }
  const reader = new FileReader();
  reader.onload = (e: any) => {
    const ab = e.target.result;
    const wb = XLSX.read(ab, { type: 'array' });
    const ws = wb.Sheets[wb.SheetNames[0]];
    const data = XLSX.utils.sheet_to_json(ws, { header: 1 });

    const formattedData = data.map((row: any) => ({
      name: row[0],
      origin: row[1],
      ville: row[2],
      year: row[3],
      separation: row[4],
      fondateur: row[5],
      membre: row[6],
      music: row[7],
      presentation: row[8]
    }));
    console.log(formattedData)
    formattedData.splice(0,1);
    console.log(formattedData)
var test:any;
test=formattedData[2];
console.log(test);
    this.http.post('http://localhost:8000/upload', { bands: formattedData }).subscribe({
      next: (response) => {
        console.log('Data uploaded successfully:', response);
      },
      error: (error) => {
        console.error('Error uploading data:', error);
        if (error.error) {
          console.error('Error response from server:', error.error);
        }
      }
    });
  };

  reader.readAsArrayBuffer(this.fileToUpload);
}

onBandSelect() {
  this.selectedConcertHallId = null;
}

ngOnInit(): void {
  this.loadBands();
  this.loadConcertHalls();
}

loadBands() {
  this.bandService.getBands().subscribe((data) => {
    this.bands = data;
    console.log('Bands:', this.bands);  
  });
}

loadConcertHalls() {
  this.concertHallService.getConcertHalls().subscribe((data) => {
    this.concertHalls = data;
    console.log('Concert Halls:', this.concertHalls); 
  });
}

// assignConcertHalls(bandId: number, selectedOptions: any) {
//   const selectedConcertHalls = Array.from(selectedOptions).map((option: any) => option.value);
//   selectedConcertHalls.forEach((concertHallId: any) => {
//     this.bandService.assignConcertHall(bandId, concertHallId).subscribe(() => {
//       alert('Concert Hall assigned to Band!');
//     });
//   });
// }
submitSelection() {
  if (this.selectedBandId && this.selectedConcertHallId) {
    this.bandService.assignConcertHall(this.selectedBandId, this.selectedConcertHallId).subscribe({
      next: (response) => {
        console.log('Concert hall assigned successfully:', response);
        alert('Concert hall successfully assigned to the band!');
      },
      error: (error) => {
        console.error('Error assigning concert hall:', error);
        alert('Error assigning concert hall.');
      }
    });
  } else {
    alert('Please select both a band and a concert hall.');
  }
}

}
