import pikepdf
import sys
import json

json_data = [sys.argv[1]]
#data = json.loads(json_data)

#print(json_data)

for entry in sys.argv[0c]:
    for item in entry:
         print(item)


with pikepdf.Pdf.open('PDFs/Formulario_Sanitas.pdf') as my_pdf:
    for page in my_pdf.pages:
        page.rotate(180, relative=True)
    my_pdf.save('PDFs/Formulario_Sanitas.pdf-rotated.pdf')
